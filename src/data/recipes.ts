/**
 * Recipe / usage cards for Gaurikrit haldi products.
 * Each recipe has 3–4 steps. Used in the RecipeCarousel section.
 */

export interface RecipeStep {
  title: string
  detail: string
}

export interface Recipe {
  id: string
  productId: string
  title: string
  subtitle: string
  duration: string
  serves: string
  accent: string // CSS color for the visual accent
  steps: RecipeStep[]
}

export const RECIPES: Recipe[] = [
  {
    id: "golden-milk",
    productId: "haldi-powder",
    title: "Golden Milk (Haldi Doodh)",
    subtitle: "The household wellness ritual",
    duration: "8 min",
    serves: "1 cup",
    accent: "oklch(0.72 0.15 75)",
    steps: [
      { title: "Warm the milk", detail: "Heat 1 cup of full-fat milk on a low flame until just simmering — not boiling." },
      { title: "Add haldi", detail: "Whisk in ½ teaspoon of Gaurikrit Pure Turmeric Powder until fully dissolved." },
      { title: "Spice it", detail: "Add a pinch of black pepper (boosts curcumin absorption), a cracked cardamom pod, and ½ tsp ghee." },
      { title: "Simmer & serve", detail: "Simmer 3 minutes. Strain into your favourite cup. Sip warm before bed." },
    ],
  },
  {
    id: "face-mask",
    productId: "haldi-paste",
    title: "Brightening Haldi Face Mask",
    subtitle: "A weekly skin ritual",
    duration: "15 min",
    serves: "1 mask",
    accent: "oklch(0.80 0.10 85)",
    steps: [
      { title: "Base", detail: "Mix 1 tbsp Gaurikrit Organic Haldi Paste with 1 tbsp raw honey and 1 tbsp yoghurt." },
      { title: "Adjust", detail: "Add a few drops of rose water until the mask spreads easily but doesn't drip." },
      { title: "Apply", detail: "Brush onto clean, dry skin. Avoid the under-eye area. Relax for 10 minutes." },
      { title: "Rinse", detail: "Rinse with lukewarm water in gentle circles. Follow with a light moisturiser." },
    ],
  },
  {
    id: "wellness-shot",
    productId: "haldi-wellness",
    title: "Daily Wellness Shot",
    subtitle: "Curcumin+ with a kick",
    duration: "3 min",
    serves: "1 shot",
    accent: "oklch(0.62 0.16 65)",
    steps: [
      { title: "Warm water", detail: "Pour 60ml warm (not hot) water into a small glass." },
      { title: "Add the haldi", detail: "Stir in ½ teaspoon Gaurikrit Wellness Haldi (Curcumin+) until dissolved." },
      { title: "Brighten", detail: "Squeeze in ½ lemon and add a pinch of black pepper for absorption." },
      { title: "Sip", detail: "Drink on an empty stomach each morning. Take daily for 4–6 weeks for the habit to compound." },
    ],
  },
]
