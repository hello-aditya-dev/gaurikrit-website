"use client"

import * as React from "react"
import { Sparkles } from "lucide-react"
import { company } from "@/lib/data"
import { Marquee, MarqueeItem } from "@/components/common/marquee"

/**
 * A thin gold marquee strip of brand trust phrases.
 * Sits between the Hero and the TrustBar to add motion + reinforce brand pillars.
 */
export function MarqueeStrip() {
  const phrases = company.marquee ?? [
    "Naturally Crafted Haldi",
    "Low-VOC Premium Paint",
    "Lab-Tested Purity",
    "Pan-India Delivery",
  ]

  return (
    <div
      className="gold-gradient py-2.5 text-accent shadow-gold"
      role="presentation"
      aria-hidden="true"
    >
      <Marquee duration={32} pauseOnHover>
        {phrases.map((phrase, i) => (
          <MarqueeItem key={`${phrase}-${i}`} className="gap-3">
            <Sparkles className="h-3.5 w-3.5 text-accent/70" />
            <span className="text-xs font-semibold uppercase tracking-[0.22em] text-accent">
              {phrase}
            </span>
            <span className="ml-3 text-accent/40">◆</span>
          </MarqueeItem>
        ))}
      </Marquee>
    </div>
  )
}
