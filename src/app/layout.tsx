import type { Metadata } from "next";
import { Inter, Playfair_Display } from "next/font/google";
import { Geist_Mono } from "next/font/google";
import "./globals.css";
import { Toaster } from "@/components/ui/sonner";
import { ThemeProvider } from "@/components/theme-provider";

const inter = Inter({
  variable: "--font-inter",
  subsets: ["latin"],
  display: "swap",
});

const playfair = Playfair_Display({
  variable: "--font-playfair",
  subsets: ["latin"],
  display: "swap",
});

const geistMono = Geist_Mono({
  variable: "--font-geist-mono",
  subsets: ["latin"],
  display: "swap",
});

export const metadata: Metadata = {
  metadataBase: new URL("https://gaurikrit.example.com"),
  title: {
    default: "Gaurikrit — Naturally Crafted Haldi & Premium Paint",
    template: "%s · Gaurikrit",
  },
  description:
    "Gaurikrit brings the golden warmth of naturally crafted haldi and the precision of premium paint into every Indian home. Lab-tested purity, low-VOC paints, pan-India delivery.",
  keywords: [
    "Gaurikrit",
    "haldi",
    "turmeric",
    "natural paint",
    "premium paint",
    "low VOC paint",
    "interior paint",
    "exterior paint",
    "turmeric powder",
    "curcumin",
    "Indian paint brand",
  ],
  authors: [{ name: "Gaurikrit" }],
  creator: "Gaurikrit",
  openGraph: {
    type: "website",
    locale: "en_IN",
    url: "https://gaurikrit.example.com",
    siteName: "Gaurikrit",
    title: "Gaurikrit — Naturally Crafted Haldi & Premium Paint",
    description:
      "The golden warmth of haldi meets the precision of premium paint. Naturally crafted, scientifically trusted.",
  },
  twitter: {
    card: "summary_large_image",
    title: "Gaurikrit — Naturally Crafted Haldi & Premium Paint",
    description:
      "The golden warmth of haldi meets the precision of premium paint. Naturally crafted, scientifically trusted.",
  },
  icons: {
    icon: "/logo.svg",
  },
  robots: {
    index: true,
    follow: true,
  },
};

const jsonLd = {
  "@context": "https://schema.org",
  "@type": "Organization",
  name: "Gaurikrit",
  description:
    "Indian brand producing naturally crafted haldi (turmeric) and premium paint products.",
  foundingDate: "1998",
  knowsAbout: ["turmeric", "curcumin", "paint", "low-VOC", "natural paint"],
  address: {
    "@type": "PostalAddress",
    streetAddress: "12, Lake View Road, Ballygunge",
    addressLocality: "Kolkata",
    addressRegion: "West Bengal",
    postalCode: "700019",
    addressCountry: "IN",
  },
  contactPoint: {
    "@type": "ContactPoint",
    telephone: "+91-98300-00000",
    contactType: "customer service",
    areaServed: "IN",
    availableLanguage: ["English", "Hindi", "Bengali"],
  },
}

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <html lang="en" suppressHydrationWarning>
      <head>
        <script
          type="application/ld+json"
          dangerouslySetInnerHTML={{ __html: JSON.stringify(jsonLd) }}
        />
      </head>
      <body
        className={`${inter.variable} ${playfair.variable} ${geistMono.variable} antialiased bg-background text-foreground`}
      >
        <ThemeProvider
          attribute="class"
          defaultTheme="light"
          enableSystem
          disableTransitionOnChange
        >
          {children}
          <Toaster richColors position="bottom-right" />
        </ThemeProvider>
      </body>
    </html>
  );
}
