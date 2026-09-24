import { NextResponse } from "next/server"
import { db } from "@/lib/db"
import { inquirySchema } from "@/lib/validations"
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

  const parsed = inquirySchema.safeParse(body)
  if (!parsed.success) {
    return NextResponse.json(
      { error: "Validation failed", issues: parsed.error.flatten().fieldErrors },
      { status: 400 }
    )
  }

  const { productId, productName, name, email, phone, message } = parsed.data

  try {
    await db.productInquiry.create({
      data: {
        productId,
        productName,
        name,
        email,
        phone: phone || null,
        message: message || "",
      },
    })
  } catch (err) {
    console.error("[inquiry] db error", err)
    return NextResponse.json({ error: "Could not save your enquiry" }, { status: 500 })
  }

  return NextResponse.json(
    { ok: true, message: `Thanks! Our team will reach out about ${productName}.` },
    { status: 201 }
  )
}
