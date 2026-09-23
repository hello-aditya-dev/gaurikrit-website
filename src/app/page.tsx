import { SiteShell } from "@/components/layout/site-shell"
import { SiteHeader } from "@/components/header/site-header"
import { Hero } from "@/components/sections/hero"
import { MarqueeStrip } from "@/components/sections/marquee-strip"
import { TrustBar } from "@/components/sections/trust-bar"
import { About } from "@/components/sections/about"
import { Products } from "@/components/sections/products"
import { Features } from "@/components/sections/features"
import { Process } from "@/components/sections/process"
import { ClaimsRegister } from "@/components/sections/claims-register"
import { Testimonials } from "@/components/sections/testimonials"
import { Faq } from "@/components/sections/faq"
import { ContactSection } from "@/components/sections/contact-section"
import { SiteFooter } from "@/components/sections/site-footer"
import { BackToTop } from "@/components/common/back-to-top"

export default function Home() {
  return (
    <SiteShell>
      <SiteHeader />
      <main id="main" className="flex-1">
        <Hero />
        <MarqueeStrip />
        <TrustBar />
        <About />
        <Products />
        <Features />
        <Process />
        <ClaimsRegister />
        <Testimonials />
        <Faq />
        <ContactSection />
      </main>
      <SiteFooter />
      <BackToTop />
    </SiteShell>
  )
}
