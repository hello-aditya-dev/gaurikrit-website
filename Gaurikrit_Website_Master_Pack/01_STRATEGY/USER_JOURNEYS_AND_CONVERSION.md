# User Journeys & Conversion

## Primary journeys

### J1 · Homeowner exploring products (Haldi)
1. Lands on hero, reads "naturally crafted haldi".
2. Scrolls to Trust bar → sees "Lab-tested purity".
3. Clicks Products → "Haldi" tab.
4. Opens "Pure Turmeric Powder" → reads claims (Curcumin 4.5%+).
5. Scans Claims Register for the curcumin claim → sees NABL ref.
6. Decides to enquire → fills Contact form (interest = Haldi).
7. Submits → toast "We'll call you in 24h" → DB row created.
8. Optionally subscribes to newsletter.

### J2 · Contractor evaluating paint
1. Lands via search "low-VOC paint India".
2. Hero → "Talk to Us" CTA.
3. Scrolls to Features → "Low-VOC" + "100% Coverage".
4. Opens "Exterior Weather Guard" → reads coverage + warranty claim.
5. Checks Claims Register for the 8-year weatherability claim.
6. Fills Contact form → selects "Bulk / Project enquiry".

### J3 · Retailer / distributor partnership
1. Lands, scrolls to footer "Partnerships" link.
2. Jumps to Contact form → selects "Partnership" interest.
3. Submits → routed to sales team via DB export.

### J4 · Returning newsletter reader
1. Reads monthly newsletter (future).
2. Clicks back to site → browses new products.
3. Converts via contact form on a future visit.

## Conversion goals (v1)

| Goal | Mechanism | Success metric |
|------|-----------|----------------|
| Lead | Contact form submit | rows in `ContactMessage` |
| Subscriber | Newsletter signup | rows in `NewsletterSubscriber` |
| Trust | Claims register views | scroll depth + claims interactions |
| Enquiry | Product "Enquire" button | rows in `ProductInquiry` |

## Micro-conversions

- Hero CTA clicks (both).
- Nav anchor clicks.
- Product card detail opens.
- Claims register searches.
- FAQ expands.
- Footer link clicks.

## Friction to remove

- No forced modals on entry.
- Contact form: max 5 fields, clear validation.
- No captcha noise — honeypot + rate-limit only.
- Phone field optional, email required.
