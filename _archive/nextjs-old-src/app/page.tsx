import { SiteShell } from "@/components/layout/site-shell"
import { SiteHeader } from "@/components/header/site-header"
import { Hero } from "@/components/sections/hero"
import { MarqueeStrip } from "@/components/sections/marquee-strip"
import { TrustBar } from "@/components/sections/trust-bar"
import { About } from "@/components/sections/about"
import { WhyTogether } from "@/components/sections/why-together"
import { Products } from "@/components/sections/products"
import { RecipeCarousel } from "@/components/sections/recipe-carousel"
import { Features } from "@/components/sections/features"
import { Process } from "@/components/sections/process"
import { CoverageCalculator } from "@/components/sections/coverage-calculator"
import { ClaimsRegister } from "@/components/sections/claims-register"
import { Testimonials } from "@/components/sections/testimonials"
import { PressStrip } from "@/components/sections/press-strip"
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
        <WhyTogether />
        <Products />
        <RecipeCarousel />
        <Features />
        <Process />
        <CoverageCalculator />
        <ClaimsRegister />
        <Testimonials />
        <PressStrip />
        <Faq />
        <ContactSection />
      </main>
      <SiteFooter />
      <BackToTop />
    </SiteShell>
  )
}
