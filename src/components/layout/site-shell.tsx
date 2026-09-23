import * as React from "react"
import { cn } from "@/lib/utils"

export function SiteShell({ children }: { children: React.ReactNode }) {
  return (
    <div className="relative flex min-h-screen flex-col bg-background">
      {children}
    </div>
  )
}

export function Container({
  children,
  className,
}: {
  children: React.ReactNode
  className?: string
}) {
  return (
    <div className={cn("mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8", className)}>
      {children}
    </div>
  )
}

type Tone = "paper" | "charcoal" | "gold-tint" | "default"

const toneClasses: Record<Tone, string> = {
  paper: "bg-background",
  charcoal: "bg-accent text-accent-foreground",
  "gold-tint": "bg-secondary",
  default: "bg-transparent",
}

export function Section({
  children,
  id,
  className,
  tone = "default",
  containerClassName,
}: {
  children: React.ReactNode
  id?: string
  className?: string
  tone?: Tone
  containerClassName?: string
}) {
  return (
    <section
      id={id}
      className={cn(
        "scroll-mt-20 py-20 md:py-28",
        toneClasses[tone],
        className
      )}
    >
      <Container className={containerClassName}>{children}</Container>
    </section>
  )
}

export function SectionHeading({
  eyebrow,
  title,
  description,
  align = "center",
  tone = "default",
}: {
  eyebrow?: string
  title: string
  description?: string
  align?: "left" | "center"
  tone?: "default" | "on-charcoal"
}) {
  return (
    <div
      className={cn(
        "max-w-3xl",
        align === "center" ? "mx-auto text-center" : "text-left"
      )}
    >
      {eyebrow ? (
        <p
          className={cn(
            "mb-3 text-xs font-semibold uppercase tracking-[0.2em]",
            tone === "on-charcoal" ? "text-primary" : "text-primary"
          )}
        >
          {eyebrow}
        </p>
      ) : null}
      <h2
        className={cn(
          "font-display text-3xl font-bold leading-tight tracking-tight md:text-4xl lg:text-5xl",
          tone === "on-charcoal" ? "text-accent-foreground" : "text-foreground"
        )}
      >
        {title}
      </h2>
      {description ? (
        <p
          className={cn(
            "mt-4 text-base leading-relaxed md:text-lg",
            tone === "on-charcoal" ? "text-muted-foreground" : "text-muted-foreground"
          )}
        >
          {description}
        </p>
      ) : null}
    </div>
  )
}
