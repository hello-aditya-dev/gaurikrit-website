"use client"

import * as React from "react"
import { motion, AnimatePresence, useReducedMotion } from "framer-motion"
import {
  ShieldCheck,
  Building2,
  Hash,
  Calendar,
  CheckCircle2,
  FileText,
} from "lucide-react"
import {
  Dialog,
  DialogContent,
  DialogHeader,
  DialogTitle,
  DialogDescription,
} from "@/components/ui/dialog"
import { Badge } from "@/components/ui/badge"
import { Separator } from "@/components/ui/separator"
import type { CertificationDetail } from "@/data/certifications"
import { track } from "@/lib/analytics"

interface CertificationModalProps {
  cert: CertificationDetail | null
  open: boolean
  onOpenChange: (open: boolean) => void
}

function formatDate(iso: string): string {
  try {
    return new Date(iso).toLocaleDateString("en-IN", {
      day: "2-digit",
      month: "short",
      year: "numeric",
    })
  } catch {
    return iso
  }
}

export function CertificationModal({
  cert,
  open,
  onOpenChange,
}: CertificationModalProps) {
  const reduceMotion = useReducedMotion()

  return (
    <Dialog open={open} onOpenChange={onOpenChange}>
      <DialogContent className="max-h-[90vh] overflow-y-auto p-0 sm:max-w-xl">
        <DialogHeader className="sr-only">
          <DialogTitle>{cert ? `${cert.name} certification detail` : "Certification detail"}</DialogTitle>
          <DialogDescription>
            {cert ? `Issuer, scope, and coverage for ${cert.name}.` : "Select a certification to view detail."}
          </DialogDescription>
        </DialogHeader>

        <AnimatePresence mode="wait">
          {cert ? (
            <motion.div
              key={cert.id}
              initial={reduceMotion ? false : { opacity: 0, y: 12 }}
              animate={{ opacity: 1, y: 0 }}
              exit={{ opacity: 0 }}
              transition={{ duration: 0.3, ease: [0.22, 1, 0.36, 1] }}
            >
              {/* Header */}
              <div className="relative overflow-hidden bg-accent p-6 text-accent-foreground">
                <div
                  aria-hidden="true"
                  className="pointer-events-none absolute inset-0 opacity-20"
                  style={{
                    background:
                      "radial-gradient(50% 60% at 90% 10%, oklch(0.72 0.15 75 / 0.5), transparent 70%)",
                  }}
                />
                <div className="relative flex items-start gap-4">
                  <span className="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl gold-gradient text-accent shadow-gold">
                    <ShieldCheck className="h-7 w-7" aria-hidden="true" />
                  </span>
                  <div className="min-w-0 flex-1">
                    <div className="flex flex-wrap items-center gap-2">
                      <h2 className="font-display text-2xl font-bold leading-tight text-accent-foreground">
                        {cert.name}
                      </h2>
                      <Badge className="gold-gradient text-accent">{cert.shortDesc}</Badge>
                    </div>
                    <p className="mt-1 flex items-center gap-1.5 text-sm text-muted-foreground">
                      <Building2 className="h-3.5 w-3.5 text-primary" />
                      {cert.issuer}
                    </p>
                  </div>
                </div>
              </div>

              {/* Body */}
              <div className="space-y-5 p-6">
                {/* Meta grid */}
                <div className="grid grid-cols-1 gap-3 sm:grid-cols-2">
                  <div className="rounded-xl border bg-secondary/40 p-3">
                    <p className="flex items-center gap-1.5 text-[10px] font-semibold uppercase tracking-[0.14em] text-muted-foreground">
                      <Hash className="h-3 w-3 text-primary" />
                      Certificate number
                    </p>
                    <p className="mt-1 font-mono text-sm font-semibold text-foreground">
                      {cert.certificateNumber}
                    </p>
                  </div>
                  <div className="rounded-xl border bg-secondary/40 p-3">
                    <p className="flex items-center gap-1.5 text-[10px] font-semibold uppercase tracking-[0.14em] text-muted-foreground">
                      <Calendar className="h-3 w-3 text-primary" />
                      Issued
                    </p>
                    <p className="mt-1 text-sm font-semibold text-foreground">
                      {formatDate(cert.issuedOn)}
                      {cert.validUntil ? (
                        <span className="text-muted-foreground">
                          {" "}· valid till {formatDate(cert.validUntil)}
                        </span>
                      ) : null}
                    </p>
                  </div>
                </div>

                {/* Scope */}
                <div>
                  <h3 className="mb-1.5 flex items-center gap-1.5 text-xs font-semibold uppercase tracking-[0.14em] text-foreground">
                    <FileText className="size-3.5 text-primary" />
                    Scope
                  </h3>
                  <p className="text-sm leading-relaxed text-muted-foreground">
                    {cert.scope}
                  </p>
                </div>

                <Separator />

                {/* What it means */}
                <div className="rounded-xl border border-primary/30 bg-primary/[0.04] p-4">
                  <p className="text-[10px] font-semibold uppercase tracking-[0.14em] text-primary">
                    What it means for you
                  </p>
                  <p className="mt-1.5 text-sm leading-relaxed text-foreground">
                    {cert.whatItMeans}
                  </p>
                </div>

                {/* Covers */}
                <div>
                  <h3 className="mb-2 text-xs font-semibold uppercase tracking-[0.14em] text-foreground">
                    What this cert covers
                  </h3>
                  <ul className="space-y-2">
                    {cert.covers.map((item) => (
                      <li key={item} className="flex items-start gap-2.5 text-sm text-foreground">
                        <CheckCircle2 className="mt-0.5 size-4 shrink-0 text-primary" />
                        {item}
                      </li>
                    ))}
                  </ul>
                </div>

                <p className="pt-2 text-center text-[10px] text-muted-foreground">
                  Certificate numbers are indicative for v1. Real numbers will be confirmed before public launch.
                </p>
              </div>
            </motion.div>
          ) : null}
        </AnimatePresence>
      </DialogContent>
    </Dialog>
  )
}
