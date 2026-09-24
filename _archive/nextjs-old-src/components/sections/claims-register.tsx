"use client"

import * as React from "react"
import { motion, useReducedMotion } from "framer-motion"
import { Search, Copy, SearchX } from "lucide-react"
import { toast } from "sonner"

import { claimsData, allClaims } from "@/lib/data"
import { track } from "@/lib/analytics"
import type { Claim } from "@/types"
import { cn } from "@/lib/utils"
import {
  Section,
  SectionHeading,
} from "@/components/layout/site-shell"
import { Input } from "@/components/ui/input"
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select"
import { Button } from "@/components/ui/button"
import { Badge } from "@/components/ui/badge"
import { Card, CardContent } from "@/components/ui/card"
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table"

/** Category badge color mapping per spec */
function categoryBadgeClass(category: Claim["category"]): string {
  switch (category) {
    case "material":
      return "bg-primary text-primary-foreground border-transparent"
    case "performance":
      return "bg-accent text-accent-foreground border-transparent"
    case "safety":
    default:
      return "bg-secondary text-secondary-foreground border-transparent"
  }
}

function formatDate(iso: string): string {
  try {
    const d = new Date(iso)
    if (Number.isNaN(d.getTime())) return iso
    return d.toLocaleDateString("en-IN", {
      day: "2-digit",
      month: "short",
      year: "numeric",
    })
  } catch {
    return iso
  }
}

async function copyReference(ref: string) {
  try {
    if (navigator?.clipboard?.writeText) {
      await navigator.clipboard.writeText(ref)
    } else {
      // Fallback for environments without async clipboard
      const el = document.createElement("textarea")
      el.value = ref
      el.setAttribute("readonly", "")
      el.style.position = "absolute"
      el.style.left = "-9999px"
      document.body.appendChild(el)
      el.select()
      document.execCommand("copy")
      document.body.removeChild(el)
    }
    toast.success("Reference copied: " + ref)
    track("claim_copy_reference", { reference: ref })
  } catch {
    toast.error("Could not copy reference")
  }
}

export function ClaimsRegister() {
  const [query, setQuery] = React.useState("")
  const [category, setCategory] = React.useState("all")
  const searchDebounce = React.useRef<ReturnType<typeof setTimeout> | null>(null)

  const prefersReducedMotion = useReducedMotion()

  const onQueryChange = React.useCallback((value: string) => {
    setQuery(value)
    if (searchDebounce.current) clearTimeout(searchDebounce.current)
    searchDebounce.current = setTimeout(() => {
      track("claim_search", { query: value })
    }, 600)
  }, [])

  const onCategoryChange = React.useCallback((value: string) => {
    setCategory(value)
    track("claim_filter", { category: value })
  }, [])

  const filtered = React.useMemo(() => {
    const q = query.trim().toLowerCase()
    return allClaims.filter((c) => {
      const matchesCategory = category === "all" || c.category === category
      if (!matchesCategory) return false
      if (!q) return true
      return (
        c.claim.toLowerCase().includes(q) ||
        c.reference.toLowerCase().includes(q) ||
        c.source.toLowerCase().includes(q)
      )
    })
  }, [query, category])

  const revealProps = prefersReducedMotion
    ? {}
    : {
        initial: { opacity: 0, y: 24 },
        whileInView: { opacity: 1, y: 0 },
        viewport: { once: true, margin: "-80px" },
        transition: { duration: 0.6, ease: "easeOut" as const },
      }

  return (
    <Section id="claims" tone="paper" className="bg-grain">
      <SectionHeading
        eyebrow="Claims Register"
        title="Every claim, sourced. No exceptions."
        description="Search our public register. Every statement on this site is backed by a test, a certificate, or an audit."
      />

      {/* Toolbar */}
      <div className="mx-auto mt-10 flex max-w-5xl flex-wrap items-center gap-3">
        <div className="relative min-w-[220px] flex-1">
          <Search className="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground" />
          <Input
            type="search"
            value={query}
            onChange={(e) => onQueryChange(e.target.value)}
            placeholder="Search by claim, reference, or source"
            aria-label="Search claims"
            className="h-11 pl-9"
          />
        </div>
        <Select value={category} onValueChange={onCategoryChange}>
          <SelectTrigger
            className="h-11 w-[180px]"
            aria-label="Filter claims by category"
          >
            <SelectValue placeholder="Filter by category" />
          </SelectTrigger>
          <SelectContent>
            {claimsData.categories.map((cat) => (
              <SelectItem key={cat.id} value={cat.id}>
                {cat.label}
              </SelectItem>
            ))}
          </SelectContent>
        </Select>
      </div>

      {/* Results count */}
      <p className="mx-auto mt-4 max-w-5xl text-sm text-muted-foreground" role="status" aria-live="polite">
        Showing {filtered.length} of {allClaims.length} claims
      </p>

      {/* Desktop table */}
      <motion.div
        className="mx-auto mt-6 hidden max-w-5xl rounded-xl border bg-card shadow-soft md:block"
        {...revealProps}
      >
        <Table>
          <TableHeader>
            <TableRow className="bg-secondary/40 hover:bg-secondary/40">
              <TableHead className="w-[42%] pl-4 text-left">Claim</TableHead>
              <TableHead className="text-left">Category</TableHead>
              <TableHead className="text-left">Source</TableHead>
              <TableHead className="text-left">Reference</TableHead>
              <TableHead className="text-left">Verified</TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            {filtered.length === 0 ? (
              <TableRow>
                <TableCell colSpan={5} className="py-12">
                  <div className="flex flex-col items-center justify-center gap-3 text-muted-foreground">
                    <SearchX className="h-8 w-8" />
                    <p className="text-sm">No claims match your search.</p>
                  </div>
                </TableCell>
              </TableRow>
            ) : (
              filtered.map((c) => (
                <TableRow
                  key={c.id}
                  className="hover:bg-secondary/50"
                >
                  <TableCell className="max-w-[420px] pl-4 pr-4 align-top text-left">
                    <span className="text-sm leading-relaxed text-foreground">
                      {c.claim}
                    </span>
                  </TableCell>
                  <TableCell className="align-top">
                    <Badge className={cn("capitalize", categoryBadgeClass(c.category))}>
                      {c.categoryLabel}
                    </Badge>
                  </TableCell>
                  <TableCell className="max-w-[200px] align-top text-left text-sm text-muted-foreground">
                    {c.source}
                  </TableCell>
                  <TableCell className="align-top text-left">
                    <span className="inline-flex items-center gap-2">
                      <code className="font-mono text-xs text-foreground">
                        {c.reference}
                      </code>
                      <Button
                        type="button"
                        variant="ghost"
                        size="icon"
                        className="h-7 w-7 text-muted-foreground hover:text-primary"
                        onClick={() => copyReference(c.reference)}
                        aria-label={`Copy reference ${c.reference}`}
                      >
                        <Copy className="h-3.5 w-3.5" />
                      </Button>
                    </span>
                  </TableCell>
                  <TableCell className="align-top text-left text-sm text-muted-foreground">
                    {formatDate(c.verifiedOn)}
                  </TableCell>
                </TableRow>
              ))
            )}
          </TableBody>
        </Table>
      </motion.div>

      {/* Mobile card list */}
      <motion.div
        className="mx-auto mt-6 flex max-w-5xl flex-col gap-3 md:hidden"
        {...revealProps}
      >
        {filtered.length === 0 ? (
          <div className="flex flex-col items-center justify-center gap-3 rounded-xl border border-dashed py-12 text-muted-foreground">
            <SearchX className="h-8 w-8" />
            <p className="text-sm">No claims match your search.</p>
          </div>
        ) : (
          filtered.map((c) => (
            <Card key={c.id} className="gap-3 py-4 shadow-soft">
              <CardContent className="space-y-3">
                <div className="flex items-start justify-between gap-3">
                  <p className="text-sm font-semibold leading-snug text-foreground">
                    {c.claim}
                  </p>
                  <Badge
                    className={cn(
                      "shrink-0 capitalize",
                      categoryBadgeClass(c.category)
                    )}
                  >
                    {c.categoryLabel}
                  </Badge>
                </div>
                <dl className="grid grid-cols-[auto_1fr] gap-x-3 gap-y-1.5 text-xs">
                  <dt className="font-medium uppercase tracking-wide text-muted-foreground">
                    Source
                  </dt>
                  <dd className="text-foreground">{c.source}</dd>
                  <dt className="font-medium uppercase tracking-wide text-muted-foreground">
                    Reference
                  </dt>
                  <dd className="text-foreground">
                    <span className="inline-flex items-center gap-2">
                      <code className="font-mono">{c.reference}</code>
                      <Button
                        type="button"
                        variant="ghost"
                        size="icon"
                        className="h-7 w-7 text-muted-foreground hover:text-primary"
                        onClick={() => copyReference(c.reference)}
                        aria-label={`Copy reference ${c.reference}`}
                      >
                        <Copy className="h-3.5 w-3.5" />
                      </Button>
                    </span>
                  </dd>
                  <dt className="font-medium uppercase tracking-wide text-muted-foreground">
                    Verified
                  </dt>
                  <dd className="text-foreground">{formatDate(c.verifiedOn)}</dd>
                </dl>
              </CardContent>
            </Card>
          ))
        )}
      </motion.div>
    </Section>
  )
}

export default ClaimsRegister
