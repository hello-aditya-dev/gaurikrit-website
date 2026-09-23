import type { Metadata } from "next";
import { Inter, Playfair_Display, Tiro_Devanagari_Hindi } from "next/font/google";
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

const tiro = Tiro_Devanagari_Hindi({
  variable: "--font-tiro",
  subsets: ["devanagari"],
  display: "swap",
  weight: "400",
});

const geistMono = Geist_Mono({
  variable: "--font-geist-mono",
  subsets: ["latin"],
  display: "swap",
});

export const metadata: Metadata = {
  metadataBase: new URL("https://gaurikrit.bio"),
  title: {
    default: "Gaurikrit Bio Products — Prakritik Paint. Walls that breathe sustainability.",
    template: "%s · Gaurikrit Bio Products",
  },
  description:
    "Gaurikrit Bio Products makes Prakritik Paint — cow dung-based natural paint in distemper and emulsion formats for interior and exterior walls. Walls that breathe sustainability.",
  keywords: [
    "Gaurikrit",
    "Prakritik Paint",
    "cow dung paint",
    "natural paint",
    "distemper",
    "emulsion",
    "bio products",
    "sustainable paint India",
    "limewash",
    "gaushala",
  ],
  authors: [{ name: "Gaurikrit Bio Products" }],
  creator: "Gaurikrit Bio Products",
  openGraph: {
    type: "website",
    locale: "en_IN",
    url: "https://gaurikrit.bio",
    siteName: "Gaurikrit Bio Products",
    title: "Gaurikrit Bio Products — Walls that breathe sustainability.",
    description:
      "Cow dung-based Prakritik Paint in distemper and emulsion formats for interior and exterior walls.",
  },
  twitter: {
    card: "summary_large_image",
    title: "Gaurikrit Bio Products — Prakritik Paint",
    description:
      "Cow dung-based Prakritik Paint. Walls that breathe sustainability.",
  },
  icons: {
    icon: "/brand/gaurikrit-mark-temp.svg",
  },
  robots: {
    index: true,
    follow: true,
  },
};

const jsonLd = {
  "@context": "https://schema.org",
  "@type": "Organization",
  name: "Gaurikrit Bio Products",
  alternateName: "गौरीकृत",
  description:
    "Maker of Prakritik Paint — cow dung-based natural paint in distemper and emulsion formats.",
  knowsAbout: ["cow dung paint", "prakritik paint", "natural distemper", "natural emulsion", "limewash", "gaushala"],
  address: {
    "@type": "PostalAddress",
    addressCountry: "IN",
  },
  contactPoint: {
    "@type": "ContactPoint",
    contactType: "customer service",
    areaServed: "IN",
    availableLanguage: ["English", "Hindi"],
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
        className={`${inter.variable} ${playfair.variable} ${tiro.variable} ${geistMono.variable} antialiased bg-background text-foreground`}
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
