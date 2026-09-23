import { z } from "zod"

export const contactSchema = z.object({
  name: z.string().min(2, "Please enter your name").max(80),
  email: z.string().email("Please enter a valid email"),
  phone: z
    .string()
    .max(20)
    .regex(/^[+0-9\s-]*$/, "Phone can only contain digits, spaces, + and -")
    .optional()
    .or(z.literal("")),
  interest: z.enum(["Haldi", "Paint", "Partnership", "General"]).default("General"),
  message: z.string().min(10, "Please tell us a bit more (min 10 characters)").max(2000),
  company: z.string().max(0, "Spam detected").optional().or(z.literal("")),
})

export type ContactInput = z.infer<typeof contactSchema>

export const newsletterSchema = z.object({
  email: z.string().email("Please enter a valid email"),
})

export type NewsletterInput = z.infer<typeof newsletterSchema>

export const inquirySchema = z.object({
  productId: z.string().min(1),
  productName: z.string().min(1),
  name: z.string().min(2, "Please enter your name").max(80),
  email: z.string().email("Please enter a valid email"),
  phone: z
    .string()
    .max(20)
    .regex(/^[+0-9\s-]*$/, "Phone can only contain digits, spaces, + and -")
    .optional()
    .or(z.literal("")),
  message: z.string().max(2000).optional().or(z.literal("")),
})

export type InquiryInput = z.infer<typeof inquirySchema>
