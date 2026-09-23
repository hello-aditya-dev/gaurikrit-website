// Simple in-memory rate limiter (per-IP token bucket).
// Resets every minute. Suitable for single-instance v1.

type Bucket = { count: number; resetAt: number }

const buckets = new Map<string, Bucket>()
const WINDOW_MS = 60_000
const MAX = 5

export function rateLimit(ip: string): { ok: boolean; remaining: number; retryAfter: number } {
  const now = Date.now()
  const existing = buckets.get(ip)

  if (!existing || existing.resetAt < now) {
    buckets.set(ip, { count: 1, resetAt: now + WINDOW_MS })
    return { ok: true, remaining: MAX - 1, retryAfter: 0 }
  }

  existing.count += 1
  if (existing.count > MAX) {
    return { ok: false, remaining: 0, retryAfter: Math.ceil((existing.resetAt - now) / 1000) }
  }

  return { ok: true, remaining: MAX - existing.count, retryAfter: 0 }
}

export function getClientIp(req: Request): string {
  const fwd = req.headers.get("x-forwarded-for")
  if (fwd) return fwd.split(",")[0].trim()
  const real = req.headers.get("x-real-ip")
  if (real) return real
  return "unknown"
}
