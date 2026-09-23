"use client"

import * as React from "react"
import Link from "next/link"
import { Menu, Phone } from "lucide-react"
import { motion, AnimatePresence } from "framer-motion"
import { Button } from "@/components/ui/button"
import {
  Sheet,
  SheetContent,
  SheetTrigger,
  SheetTitle,
  SheetClose,
} from "@/components/ui/sheet"
import { ThemeToggle } from "@/components/theme-toggle"
import { navigation } from "@/lib/data"
import { cn } from "@/lib/utils"

export function SiteHeader() {
  const [scrolled, setScrolled] = React.useState(false)
  const [mobileOpen, setMobileOpen] = React.useState(false)

  React.useEffect(() => {
    const onScroll = () => setScrolled(window.scrollY > 24)
    onScroll()
    window.addEventListener("scroll", onScroll, { passive: true })
    return () => window.removeEventListener("scroll", onScroll)
  }, [])

  return (
    <header
      className={cn(
        "fixed inset-x-0 top-0 z-50 transition-all duration-300",
        scrolled
          ? "border-b border-border bg-background/85 backdrop-blur-md shadow-soft"
          : "border-b border-transparent bg-transparent"
      )}
    >
      <div className="mx-auto flex h-16 w-full max-w-7xl items-center justify-between px-4 sm:px-6 lg:h-20 lg:px-8">
        {/* Logo */}
        <Link
          href="#home"
          className="group flex items-center gap-2.5"
          aria-label="Gaurikrit home"
        >
          <span className="relative flex h-9 w-9 items-center justify-center rounded-full gold-gradient shadow-gold">
            <span className="font-display text-lg font-bold text-accent">G</span>
          </span>
          <span className="flex flex-col leading-none">
            <span className="font-display text-lg font-bold tracking-tight text-foreground">
              Gaurikrit
            </span>
            <span className="text-[10px] uppercase tracking-[0.18em] text-muted-foreground">
              Haldi & Paint
            </span>
          </span>
        </Link>

        {/* Desktop nav */}
        <nav className="hidden items-center gap-1 lg:flex" aria-label="Primary">
          {navigation.primary.map((link) => (
            <Link
              key={link.href}
              href={link.href}
              className="group relative rounded-md px-3 py-2 text-sm font-medium text-foreground/80 transition-colors hover:text-foreground"
            >
              {link.label}
              <span className="absolute inset-x-3 -bottom-0.5 h-0.5 origin-left scale-x-0 bg-primary transition-transform duration-300 group-hover:scale-x-100" />
            </Link>
          ))}
        </nav>

        {/* Actions */}
        <div className="flex items-center gap-2">
          <a
            href={`tel:${navigation.cta.href}`}
            className="hidden items-center gap-2 text-sm font-medium text-foreground/80 transition-colors hover:text-foreground md:flex"
          >
            <Phone className="h-4 w-4 text-primary" />
            <span className="hidden xl:inline">Talk to us</span>
          </a>
          <Button
            asChild
            size="sm"
            className="hidden rounded-full gold-gradient text-accent shadow-gold hover:opacity-90 sm:inline-flex"
          >
            <Link href={navigation.cta.href}>{navigation.cta.label}</Link>
          </Button>
          <ThemeToggle />

          {/* Mobile menu */}
          <Sheet open={mobileOpen} onOpenChange={setMobileOpen}>
            <SheetTrigger asChild>
              <Button
                variant="ghost"
                size="icon"
                className="lg:hidden"
                aria-label="Open menu"
              >
                <Menu className="h-5 w-5" />
              </Button>
            </SheetTrigger>
            <SheetContent
              side="right"
              className="w-[300px] border-l border-border bg-background p-0"
            >
              <div className="flex h-full flex-col">
                <div className="flex items-center justify-between border-b border-border px-5 py-4">
                  <SheetTitle className="font-display text-lg font-bold">
                    Menu
                  </SheetTitle>
                  <SheetClose asChild>
                    <Button variant="ghost" size="icon" aria-label="Close menu">
                      <Menu className="h-5 w-5 rotate-45" />
                    </Button>
                  </SheetClose>
                </div>
                <nav
                  className="flex flex-col gap-1 px-3 py-4"
                  aria-label="Mobile"
                >
                  {navigation.primary.map((link, i) => (
                    <motion.div
                      key={link.href}
                      initial={{ opacity: 0, x: 12 }}
                      animate={{ opacity: 1, x: 0 }}
                      transition={{ delay: i * 0.05 }}
                    >
                      <SheetClose asChild>
                        <Link
                          href={link.href}
                          className="flex items-center justify-between rounded-lg px-3 py-3 text-base font-medium text-foreground/90 transition-colors hover:bg-secondary"
                        >
                          {link.label}
                          <span className="text-primary">→</span>
                        </Link>
                      </SheetClose>
                    </motion.div>
                  ))}
                </nav>
                <div className="mt-auto border-t border-border p-5">
                  <Button
                    asChild
                    className="w-full rounded-full gold-gradient text-accent shadow-gold"
                  >
                    <SheetClose asChild>
                      <Link href={navigation.cta.href}>
                        {navigation.cta.label}
                      </Link>
                    </SheetClose>
                  </Button>
                  <p className="mt-4 text-center text-xs text-muted-foreground">
                    Naturally crafted since 1998
                  </p>
                </div>
              </div>
            </SheetContent>
          </Sheet>
        </div>
      </div>
    </header>
  )
}
