# Asset provenance

The public assets in `dist-hostinger/assets/` are built by `python3 scripts/prepare_assets.py` from the material in `source-assets/`.

| Source | Public use |
| --- | --- |
| `Gaurikrit_Haldi-Black.pdf` | Official client logo; cropped without redrawing for site mark, favicons and social images |
| `prakritik-group.jpg` | Client-supplied Prakritik Paint packaging photo; intact group image and non-generative crops of Distemper and Emulsion buckets |
| `Broucher-paint.pdf` | Client-supplied product brochure; unmodified PDF plus raster cover |
| `zebu-study.png` | Generated editorial cow study, illustrative context only; never a product photograph |
| `courtyard-study.png` | Generated editorial courtyard, illustrative context only; never presented as a customer project |

The four-panel AI concept and kraft packaging mockup were excluded from public pages because they depict unconfirmed products or claims. Cropping and compression preserve the text on the supplied product packaging. Social cards add text through Pillow, separate from those photographs.

The PHP/Hostinger site uses the assets in `dist-hostinger/`. `node build-static.mjs` copies those identical assets to the noindex GitHub Pages preview in `docs/`.
