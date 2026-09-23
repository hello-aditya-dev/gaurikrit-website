"use client"

import * as React from "react"
import { useForm, type Resolver } from "react-hook-form"
import { zodResolver } from "@hookform/resolvers/zod"
import { motion, useReducedMotion } from "framer-motion"
import { MapPin, Phone, Mail, Clock, Loader2, Send } from "lucide-react"
import { toast } from "sonner"

import { company } from "@/lib/data"
import {
  contactSchema,
  newsletterSchema,
  type ContactInput,
} from "@/lib/validations"
import {
  Section,
  SectionHeading,
} from "@/components/layout/site-shell"
import {
  Form,
  FormControl,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
} from "@/components/ui/form"
import { Input } from "@/components/ui/input"
import { Textarea } from "@/components/ui/textarea"
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select"
import { Button } from "@/components/ui/button"
import { Card, CardContent } from "@/components/ui/card"

const INTERESTS = ["Haldi", "Paint", "Partnership", "General"] as const

interface InquiryEventDetail {
  productName?: string
}

export function ContactSection() {
  const prefersReducedMotion = useReducedMotion()

  const [submitting, setSubmitting] = React.useState(false)
  const [newsEmail, setNewsEmail] = React.useState("")
  const [newsSubmitting, setNewsSubmitting] = React.useState(false)

  const form = useForm<ContactInput>({
    // Cast bypasses a generic mismatch between
    // @hookform/resolvers v5 and react-hook-form v7.60's Resolver type.
    resolver: zodResolver(contactSchema) as Resolver<ContactInput>,
    defaultValues: {
      name: "",
      email: "",
      phone: "",
      interest: "General",
      message: "",
      company: "",
    },
  })

  // Listen for inquiry events from the Product Dialog
  React.useEffect(() => {
    const handler = (e: Event) => {
      const detail = (e as CustomEvent<InquiryEventDetail>).detail ?? {}
      const productName = detail.productName
      if (!productName) return
      form.setValue("interest", "Paint")
      form.setValue("message", `I'd like to know more about ${productName}.`)
      toast.info(`Prefilled a query about ${productName}`)
    }
    window.addEventListener("gaurikrit:inquiry", handler as EventListener)
    return () =>
      window.removeEventListener("gaurikrit:inquiry", handler as EventListener)
  }, [form])

  async function onContactSubmit(values: ContactInput) {
    setSubmitting(true)
    try {
      const res = await fetch("/api/contact", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(values),
      })
      const data = (await res.json().catch(() => ({}))) as {
        message?: string
        error?: string
        issues?: Record<string, string[]>
      }

      if (res.status === 201) {
        toast.success(
          data.message ||
            "Thanks! Our team will reach out within one business day."
        )
        form.reset()
        return
      }

      if (res.status === 400) {
        if (data.issues && typeof data.issues === "object") {
          for (const [field, messages] of Object.entries(data.issues)) {
            if (Array.isArray(messages) && messages.length) {
              form.setError(field as keyof ContactInput, {
                type: "server",
                message: String(messages[0]),
              })
            }
          }
        }
        toast.error(data.error || "Please check the form and try again.")
        return
      }

      if (res.status === 429) {
        toast.error("Too many attempts. Please wait a minute.")
        return
      }

      if (res.status >= 500) {
        toast.error("Something went wrong. Please email us directly.")
        return
      }

      toast.error(
        data.error || "Something went wrong. Please email us directly."
      )
    } catch {
      toast.error(
        "Network error. Please email us directly at hello@gaurikrit.in."
      )
    } finally {
      setSubmitting(false)
    }
  }

  async function onNewsletterSubmit(e: React.FormEvent) {
    e.preventDefault()
    const parsed = newsletterSchema.safeParse({ email: newsEmail })
    if (!parsed.success) {
      toast.error(
        parsed.error.issues[0]?.message || "Please enter a valid email"
      )
      return
    }
    setNewsSubmitting(true)
    try {
      const res = await fetch("/api/newsletter", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ email: newsEmail }),
      })
      const data = (await res.json().catch(() => ({}))) as {
        message?: string
        error?: string
      }
      if (res.ok) {
        toast.success(
          data.message || "You're in. Watch your inbox for golden updates."
        )
        setNewsEmail("")
        return
      }
      if (res.status === 429) {
        toast.error("Too many attempts. Please wait a minute.")
        return
      }
      toast.error(data.error || "Could not subscribe you right now.")
    } catch {
      toast.error("Network error. Please retry.")
    } finally {
      setNewsSubmitting(false)
    }
  }

  const revealProps = prefersReducedMotion
    ? {}
    : {
        initial: { opacity: 0, y: 24 },
        whileInView: { opacity: 1, y: 0 },
        viewport: { once: true, margin: "-80px" },
        transition: { duration: 0.6, ease: "easeOut" as const },
      }

  return (
    <Section id="contact" tone="charcoal">
      <SectionHeading
        tone="on-charcoal"
        eyebrow="Get in Touch"
        title="Let's craft something golden together."
        description="Tell us what you need. Our team responds within one business day."
      />

      <motion.div
        className="mx-auto mt-10 grid max-w-5xl gap-8 lg:grid-cols-2"
        {...revealProps}
      >
        {/* LEFT — contact form */}
        <Card className="bg-card text-card-foreground shadow-soft">
          <CardContent>
            <Form {...form}>
              <form
                onSubmit={form.handleSubmit(onContactSubmit)}
                className="space-y-5"
                noValidate
              >
                {/* Honeypot — visually hidden, but bots fill it */}
                <input
                  type="text"
                  tabIndex={-1}
                  autoComplete="off"
                  aria-hidden="true"
                  {...form.register("company")}
                  className="sr-only"
                />

                <FormField
                  control={form.control}
                  name="name"
                  render={({ field }) => (
                    <FormItem>
                      <FormLabel>
                        Name <span className="text-destructive">*</span>
                      </FormLabel>
                      <FormControl>
                        <Input
                          type="text"
                          autoComplete="name"
                          placeholder="Your full name"
                          className="h-11"
                          aria-required="true"
                          {...field}
                        />
                      </FormControl>
                      <FormMessage className="text-xs" role="alert" />
                    </FormItem>
                  )}
                />

                <div className="grid gap-5 sm:grid-cols-2">
                  <FormField
                    control={form.control}
                    name="email"
                    render={({ field }) => (
                      <FormItem>
                        <FormLabel>
                          Email <span className="text-destructive">*</span>
                        </FormLabel>
                        <FormControl>
                          <Input
                            type="email"
                            autoComplete="email"
                            placeholder="you@example.com"
                            className="h-11"
                            aria-required="true"
                            {...field}
                          />
                        </FormControl>
                        <FormMessage className="text-xs" role="alert" />
                      </FormItem>
                    )}
                  />
                  <FormField
                    control={form.control}
                    name="phone"
                    render={({ field }) => (
                      <FormItem>
                        <FormLabel>
                          Phone{" "}
                          <span className="text-muted-foreground">
                            (optional)
                          </span>
                        </FormLabel>
                        <FormControl>
                          <Input
                            type="tel"
                            autoComplete="tel"
                            placeholder="+91 98300 00000"
                            className="h-11"
                            {...field}
                          />
                        </FormControl>
                        <FormMessage className="text-xs" role="alert" />
                      </FormItem>
                    )}
                  />
                </div>

                <FormField
                  control={form.control}
                  name="interest"
                  render={({ field }) => (
                    <FormItem>
                      <FormLabel>Interest</FormLabel>
                      <Select value={field.value} onValueChange={field.onChange}>
                        <FormControl>
                          <SelectTrigger className="h-11 w-full">
                            <SelectValue placeholder="Choose an interest" />
                          </SelectTrigger>
                        </FormControl>
                        <SelectContent>
                          {INTERESTS.map((i) => (
                            <SelectItem key={i} value={i}>
                              {i}
                            </SelectItem>
                          ))}
                        </SelectContent>
                      </Select>
                      <FormMessage className="text-xs" role="alert" />
                    </FormItem>
                  )}
                />

                <FormField
                  control={form.control}
                  name="message"
                  render={({ field }) => (
                    <FormItem>
                      <FormLabel>
                        Message <span className="text-destructive">*</span>
                      </FormLabel>
                      <FormControl>
                        <Textarea
                          rows={5}
                          placeholder="Tell us what you're working on, what you need, and how we can help."
                          className="min-h-32"
                          aria-required="true"
                          {...field}
                        />
                      </FormControl>
                      <FormMessage className="text-xs" role="alert" />
                    </FormItem>
                  )}
                />

                <Button
                  type="submit"
                  disabled={submitting}
                  className="h-11 w-full rounded-full gold-gradient text-accent shadow-gold hover:opacity-90 sm:w-auto"
                >
                  {submitting ? (
                    <>
                      <Loader2 className="h-4 w-4 animate-spin" />
                      <span>Sending…</span>
                    </>
                  ) : (
                    <>
                      <Send className="h-4 w-4" />
                      <span>Send Message</span>
                    </>
                  )}
                </Button>
              </form>
            </Form>
          </CardContent>
        </Card>

        {/* RIGHT — newsletter + contact details */}
        <div className="flex flex-col gap-6">
          {/* Newsletter card */}
          <div className="rounded-xl border border-primary/40 bg-card/95 p-6 shadow-soft">
            <h3 className="font-display text-xl font-bold text-card-foreground">
              Join 12,000+ readers
            </h3>
            <p className="mt-2 text-sm leading-relaxed text-muted-foreground">
              Golden updates — new batches, shade launches, craft stories.
              Once a month. Unsubscribe anytime.
            </p>
            <form
              onSubmit={onNewsletterSubmit}
              className="mt-5 flex flex-col gap-3 sm:flex-row"
              noValidate
            >
              <Input
                type="email"
                required
                value={newsEmail}
                onChange={(e) => setNewsEmail(e.target.value)}
                placeholder="you@example.com"
                aria-label="Newsletter email"
                className="h-11"
              />
              <Button
                type="submit"
                disabled={newsSubmitting}
                className="h-11 shrink-0 rounded-full gold-gradient text-accent shadow-gold hover:opacity-90"
              >
                {newsSubmitting ? (
                  <>
                    <Loader2 className="h-4 w-4 animate-spin" />
                    <span>Subscribing…</span>
                  </>
                ) : (
                  <span>Subscribe</span>
                )}
              </Button>
            </form>
          </div>

          {/* Contact details */}
          <div className="rounded-xl border border-white/10 bg-white/5 p-6">
            <h3 className="font-display text-lg font-bold text-accent-foreground">
              Reach us directly
            </h3>
            <ul className="mt-4 space-y-4 text-sm">
              <li className="flex gap-3">
                <MapPin className="mt-0.5 h-5 w-5 shrink-0 text-primary" />
                <span className="text-muted-foreground">
                  {company.contact.address}
                </span>
              </li>
              <li className="flex items-center gap-3">
                <Phone className="h-5 w-5 shrink-0 text-primary" />
                <a
                  href={`tel:${company.contact.phone.replace(/\s/g, "")}`}
                  className="text-muted-foreground hover:text-accent-foreground"
                >
                  {company.contact.phone}
                </a>
              </li>
              <li className="flex items-center gap-3">
                <Mail className="h-5 w-5 shrink-0 text-primary" />
                <a
                  href={`mailto:${company.contact.email}`}
                  className="text-muted-foreground hover:text-accent-foreground"
                >
                  {company.contact.email}
                </a>
              </li>
              <li className="flex items-center gap-3">
                <Clock className="h-5 w-5 shrink-0 text-primary" />
                <span className="text-muted-foreground">
                  {company.contact.hours}
                </span>
              </li>
            </ul>
          </div>
        </div>
      </motion.div>
    </Section>
  )
}

export default ContactSection
