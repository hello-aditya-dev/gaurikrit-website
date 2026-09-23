import { NextResponse } from "next/server"
import { db } from "@/lib/db"
import { contactSchema } from "@/lib/validations"
import { rateLimit, getClientIp } from "@/lib/rate-limit"
import { allProducts } from "@/lib/data"

export const dynamic = "force-dynamic"

export async function GET() {
  return NextResponse.json({
    ok: true,
    count: allProducts.length,
    categories: ["all", "haldi", "paint"],
    items: allProducts,
  })
}

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

  const parsed = contactSchema.safeParse(body)
  if (!parsed.success) {
    return NextResponse.json(
      { error: "Validation failed", issues: parsed.error.flatten().fieldErrors },
      { status: 400 }
    )
  }

  const { name, email, phone, interest, message } = parsed.data

  try {
    await db.contactMessage.create({
      data: {
        name,
        email,
        phone: phone || null,
        interest,
        message,
      },
    })
  } catch (err) {
    console.error("[contact] db error", err)
    return NextResponse.json({ error: "Could not save your message" }, { status: 500 })
  }

  return NextResponse.json(
    { ok: true, message: "Thanks! Our team will reach out within 24 hours." },
    { status: 201 }
  )
}
