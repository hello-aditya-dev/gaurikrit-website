"use client"

import * as React from "react"
import Link from "next/link"
import { MapPin, Phone, Mail, Clock, Instagram, Facebook, Youtube, Linkedin } from "lucide-react"
// Note: lucide-react exports the icon as `Linkedin`; alias here for clarity.
import { company, navigation } from "@/lib/data"
import { Separator } from "@/components/ui/separator"
import { Input } from "@/components/ui/input"
import { Button } from "@/components/ui/button"
import { toast } from "sonner"

const socialIcons: Record<string, React.ComponentType<{ className?: string }>> = {
  Instagram,
  Facebook,
  Youtube,
  LinkedIn: Linkedin,
}

export function SiteFooter() {
  const [email, setEmail] = React.useState("")
  const [loading, setLoading] = React.useState(false)

  const onSubscribe = async (e: React.FormEvent) => {
    e.preventDefault()
    setLoading(true)
    try {
      const res = await fetch("/api/newsletter", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ email }),
      })
      const data = await res.json()
      if (res.ok) {
        toast.success(data.message || "You're in!")
        setEmail("")
      } else {
        toast.error(data.error || "Could not subscribe")
      }
    } catch {
      toast.error("Network error. Please retry.")
    } finally {
      setLoading(false)
    }
  }

  return (
    <footer id="footer" className="mt-auto bg-accent text-accent-foreground">
      {/* Newsletter strip */}
      <div className="border-b border-white/10">
        <div className="mx-auto grid max-w-7xl gap-6 px-4 py-12 sm:px-6 md:grid-cols-2 md:items-center md:gap-10 md:py-14 lg:px-8">
          <div>
            <h3 className="font-display text-2xl font-bold md:text-3xl">
              Golden updates, once a month.
            </h3>
            <p className="mt-2 text-sm text-muted-foreground">
              New batches, shade launches, and craft stories. No spam — unsubscribe anytime.
            </p>
          </div>
          <form onSubmit={onSubscribe} className="flex gap-2">
            <Input
              type="email"
              required
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              placeholder="you@example.com"
              aria-label="Email for newsletter"
              className="border-white/15 bg-white/5 text-accent-foreground placeholder:text-muted-foreground"
            />
            <Button
              type="submit"
              disabled={loading}
              className="shrink-0 rounded-full gold-gradient text-accent shadow-gold hover:opacity-90"
            >
              {loading ? "Subscribing…" : "Subscribe"}
            </Button>
          </form>
        </div>
      </div>

      {/* Main footer */}
      <div className="mx-auto grid max-w-7xl gap-10 px-4 py-14 sm:px-6 md:grid-cols-2 lg:grid-cols-4 lg:px-8">
        {/* Brand */}
        <div className="space-y-4">
          <Link href="#home" className="flex items-center gap-2.5" aria-label="Gaurikrit home">
            <span className="flex h-9 w-9 items-center justify-center rounded-full gold-gradient">
              <span className="font-display text-lg font-bold text-accent">G</span>
            </span>
            <span className="font-display text-lg font-bold">Gaurikrit</span>
          </Link>
          <p className="text-sm leading-relaxed text-muted-foreground">
            {company.tagline} Naturally crafted turmeric and lab-tested, low-VOC paints —
            made for every Indian home.
          </p>
          <div className="flex gap-2">
            {company.socials.map((s) => {
              const Icon = socialIcons[s.name] ?? Instagram
              return (
                <a
                  key={s.name}
                  href={s.href}
                  aria-label={s.name}
                  className="flex h-9 w-9 items-center justify-center rounded-full border border-white/10 text-muted-foreground transition-colors hover:border-primary hover:text-primary"
                >
                  <Icon className="h-4 w-4" />
                </a>
              )
            })}
          </div>
        </div>

        {/* Company */}
        <div>
          <h4 className="mb-4 text-xs font-semibold uppercase tracking-[0.18em] text-primary">
            Company
          </h4>
          <ul className="space-y-2.5">
            {navigation.footer.company.map((l) => (
              <li key={l.label}>
                <Link
                  href={l.href}
                  className="text-sm text-muted-foreground transition-colors hover:text-accent-foreground"
                >
                  {l.label}
                </Link>
              </li>
            ))}
          </ul>
        </div>

        {/* Products */}
        <div>
          <h4 className="mb-4 text-xs font-semibold uppercase tracking-[0.18em] text-primary">
            Products
          </h4>
          <ul className="space-y-2.5">
            {navigation.footer.products.map((l) => (
              <li key={l.label}>
                <Link
                  href={l.href}
                  className="text-sm text-muted-foreground transition-colors hover:text-accent-foreground"
                >
                  {l.label}
                </Link>
              </li>
            ))}
          </ul>
        </div>

        {/* Contact */}
        <div>
          <h4 className="mb-4 text-xs font-semibold uppercase tracking-[0.18em] text-primary">
            Get in touch
          </h4>
          <ul className="space-y-3 text-sm text-muted-foreground">
            <li className="flex gap-3">
              <MapPin className="mt-0.5 h-4 w-4 shrink-0 text-primary" />
              <span>{company.contact.address}</span>
            </li>
            <li className="flex items-center gap-3">
              <Phone className="h-4 w-4 shrink-0 text-primary" />
              <a href={`tel:${company.contact.phone}`} className="hover:text-accent-foreground">
                {company.contact.phone}
              </a>
            </li>
            <li className="flex items-center gap-3">
              <Mail className="h-4 w-4 shrink-0 text-primary" />
              <a href={`mailto:${company.contact.email}`} className="hover:text-accent-foreground">
                {company.contact.email}
              </a>
            </li>
            <li className="flex items-center gap-3">
              <Clock className="h-4 w-4 shrink-0 text-primary" />
              <span>{company.contact.hours}</span>
            </li>
          </ul>
        </div>
      </div>

      <Separator className="bg-white/10" />

      {/* Bottom bar */}
      <div className="mx-auto flex max-w-7xl flex-col items-center justify-between gap-3 px-4 py-6 text-xs text-muted-foreground sm:px-6 md:flex-row lg:px-8">
        <p>© {new Date().getFullYear()} {company.legalName}. All rights reserved.</p>
        <div className="flex gap-5">
          <Link href="#" className="hover:text-accent-foreground">Privacy</Link>
          <Link href="#" className="hover:text-accent-foreground">Terms</Link>
          <Link href="#claims" className="hover:text-accent-foreground">Claims</Link>
        </div>
        <p className="text-muted-foreground/70">Crafted with care in Kolkata, India.</p>
      </div>
    </footer>
  )
}
