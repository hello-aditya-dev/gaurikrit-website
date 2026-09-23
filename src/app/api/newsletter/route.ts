import { NextResponse } from "next/server"
import { db } from "@/lib/db"
import { newsletterSchema } from "@/lib/validations"
import { rateLimit, getClientIp } from "@/lib/rate-limit"

export const dynamic = "force-dynamic"

export async function POST(req: Request) {
  const ip = getClientIp(req)
  const limit = rateLimit(ip)
  if (!limit.ok) {
    return NextResponse.json(
      { error: "Too many requests. Please try again shortly.", retryAfter: limit.retryAfter },
      { status: 429 }
    )
  }

  let body: unknown
  try {
    body = await req.json()
  } catch {
    return NextResponse.json({ error: "Invalid JSON body" }, { status: 400 })
  }

  const parsed = newsletterSchema.safeParse(body)
  if (!parsed.success) {
    return NextResponse.json(
      { error: "Please enter a valid email", issues: parsed.error.flatten().fieldErrors },
      { status: 400 }
    )
  }

  const { email } = parsed.data

  try {
    await db.newsletterSubscriber.upsert({
      where: { email },
      update: {},
      create: { email, source: "website" },
    })
  } catch (err) {
    console.error("[newsletter] db error", err)
    // Treat duplicate as success to avoid enumeration
    if (err && typeof err === "object" && "code" in err && err.code === "P2002") {
      return NextResponse.json(
        { ok: true, message: "You're already on the list. Watch your inbox!" },
        { status: 200 }
      )
    }
    return NextResponse.json({ error: "Could not subscribe you" }, { status: 500 })
  }

  return NextResponse.json(
    { ok: true, message: "You're in. Watch your inbox for golden updates." },
    { status: 201 }
  )
}
