'use client'

import * as React from 'react'
import { Moon, Sun } from 'lucide-react'
import { useTheme } from 'next-themes'
import { Button } from '@/components/ui/button'
import { track } from '@/lib/analytics'

export function ThemeToggle() {
  const { theme, setTheme, resolvedTheme } = useTheme()
  const [mounted, setMounted] = React.useState(false)

  React.useEffect(() => setMounted(true), [])

  const isDark = (resolvedTheme ?? theme) === 'dark'

  const toggle = () => {
    const next = isDark ? 'light' : 'dark'
    setTheme(next)
    track('theme_toggle', { theme: next })
  }

  return (
    <Button
      variant="ghost"
      size="icon"
      aria-label="Toggle theme"
      onClick={toggle}
      className="rounded-full"
    >
      {mounted ? (
        isDark ? (
          <Sun className="h-5 w-5 text-primary" />
        ) : (
          <Moon className="h-5 w-5" />
        )
      ) : (
        <Sun className="h-5 w-5" />
      )}
    </Button>
  )
}
