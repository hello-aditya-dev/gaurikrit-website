"""Prepare client-supplied Gaurikrit imagery and exact-text social cards.

Requires Pillow and Poppler. Source files live in source-assets/; all public
outputs are written to the canonical dist-hostinger/ tree.
"""
from pathlib import Path
from subprocess import run
from PIL import Image, ImageChops, ImageDraw, ImageFont, ImageOps
import json

ROOT = Path(__file__).resolve().parents[1]
SRC = ROOT / 'source-assets'
OUT = ROOT / 'dist-hostinger'
ASSETS = OUT / 'assets'
for folder in ('brand', 'products', 'documents', 'illustrations', 'social'):
    (ASSETS / folder).mkdir(parents=True, exist_ok=True)

def render_pdf(filename, width_dpi=260):
    target = SRC / filename
    stem = ROOT / '.asset-render'
    run(['pdftoppm', '-f', '1', '-singlefile', '-png', '-r', str(width_dpi), str(target), str(stem)], check=True)
    im = Image.open(str(stem) + '.png').convert('RGB')
    Path(str(stem) + '.png').unlink()
    return im

def transparent_white(im):
    im = im.convert('RGBA')
    pixels = im.load()
    for y in range(im.height):
        for x in range(im.width):
            r,g,b,_ = pixels[x,y]
            a = max(0, min(255, (255-min(r,g,b))*10))
            pixels[x,y] = (r,g,b,a)
    return im

logo = transparent_white(render_pdf('Gaurikrit_Haldi-Black.pdf'))
bbox = logo.getchannel('A').getbbox()
logo = logo.crop(bbox)
mark = logo.crop((0,0,logo.width,int(logo.height*.79)))
mark = mark.crop(mark.getchannel('A').getbbox())
for name, im, size in [('gaurikrit-logo-full.png', logo, (620,620)),('gaurikrit-logo-mark.png', mark, (700,700))]:
    im.thumbnail(size, Image.Resampling.LANCZOS)
    im.save(ASSETS/'brand'/name, optimize=True)
mark = Image.open(ASSETS/'brand'/'gaurikrit-logo-mark.png').convert('RGBA')

def icon(size):
    im=Image.new('RGBA',(size,size),'#F4EFE2')
    art=mark.copy(); art.thumbnail((int(size*.87),int(size*.87)),Image.Resampling.LANCZOS)
    im.alpha_composite(art,((size-art.width)//2,(size-art.height)//2))
    return im

for size in (16,32,48,180,192,512):
    name = {16:'favicon-16x16.png',32:'favicon-32x32.png',48:'favicon-48x48.png',180:'apple-touch-icon.png',192:'android-chrome-192x192.png',512:'android-chrome-512x512.png'}[size]
    icon(size).save(OUT/name,optimize=True)
icon(512).save(OUT/'favicon.ico',format='ICO',sizes=[(16,16),(32,32),(48,48)])
(OUT/'site.webmanifest').write_text(json.dumps({'name':'Gaurikrit','short_name':'Gaurikrit','icons':[{'src':'android-chrome-192x192.png','sizes':'192x192','type':'image/png'},{'src':'android-chrome-512x512.png','sizes':'512x512','type':'image/png'}],'theme_color':'#173F2B','background_color':'#F4EFE2','display':'browser'},indent=2)+'\n')

group=Image.open(SRC/'prakritik-group.jpg').convert('RGB')
group.save(ASSETS/'products'/'prakritik-group.jpg',quality=88,optimize=True,progressive=True)
# These are crops of the client photograph; every label stays untouched.
for name,box in [('prakritik-distemper.jpg',(385,52,895,590)),('prakritik-emulsion.jpg',(895,56,1250,542))]:
    group.crop(box).save(ASSETS/'products'/name,quality=90,optimize=True,progressive=True)

brochure=SRC/'Broucher-paint.pdf'
(ASSETS/'documents'/'prakritik-paint-brochure.pdf').write_bytes(brochure.read_bytes())
cover=render_pdf('Broucher-paint.pdf',120)
cover.thumbnail((900,1200),Image.Resampling.LANCZOS)
cover.save(ASSETS/'documents'/'prakritik-paint-brochure-cover.jpg',quality=85,optimize=True,progressive=True)

for name,src in [('zebu-study.jpg','zebu-study.png'),('courtyard-study.jpg','courtyard-study.png')]:
    im=Image.open(SRC/src).convert('RGB')
    im.save(ASSETS/'illustrations'/name,quality=84,optimize=True,progressive=True)

FONT='/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'
BOLD='/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'
def fit_font(draw,text,max_w,start=69):
    for size in range(start,30,-1):
        font=ImageFont.truetype(BOLD,size)
        if draw.textbbox((0,0),text,font=font)[2] <= max_w:return font
    return ImageFont.truetype(BOLD,31)

cards = [
 ('home','Walls that Breathe','Sustainability','prakritik-group.jpg','#F4EFE2','#DEA72F'),
 ('products','Prakritik Paint','Distemper & Emulsion','prakritik-group.jpg','#F3E9D5','#D9B756'),
 ('distemper','Prakritik','Distemper Paint','prakritik-distemper.jpg','#E8F1F2','#A5C5D1'),
 ('emulsion','Prakritik','Emulsion Paint','prakritik-emulsion.jpg','#F6EBD9','#E6BD75'),
 ('why-prakritik','Why Prakritik','Paint',None,'#F4EFE2','#CCBFA8'),
 ('about','Gaurikrit','Bio Products',None,'#EAF0E7','#AFC8AE'),
 ('for-business','Projects &','Partnerships',None,'#E8EEEC','#D9B756'),
 ('calculator','Painting Budget','Calculator',None,'#E7ECED','#A5C5D1'),
 ('downloads','Prakritik Paint','Brochure','brochure','#F3E9D5','#D9B756'),
 ('contact','Talk to','Gaurikrit',None,'#F4EFE2','#DEA72F'),
]

for slug,line1,line2,photo,bg,accent in cards:
    im=Image.new('RGB',(1200,630),bg);d=ImageDraw.Draw(im)
    d.rectangle((0,0,24,630),fill='#173F2B')
    d.rounded_rectangle((720,28,1180,604),radius=18,fill=accent)
    if photo == 'brochure':
        art=Image.open(ASSETS/'documents'/'prakritik-paint-brochure-cover.jpg').convert('RGB')
    elif photo:
        art=Image.open(ASSETS/'products'/photo).convert('RGB')
    elif slug == 'why-prakritik':
        art=Image.open(ASSETS/'illustrations'/'zebu-study.jpg').convert('RGB')
    elif slug in ('for-business','calculator'):
        art=Image.open(ASSETS/'illustrations'/'courtyard-study.jpg').convert('RGB')
    else: art=None
    if art:
        bounds=(748,68,1152,560)
        if photo == 'prakritik-group.jpg':
            art = art.crop((275, 0, 975, art.height))
        thumb=ImageOps.contain(art,(bounds[2]-bounds[0],bounds[3]-bounds[1]))
        im.paste(thumb,(bounds[0]+(404-thumb.width)//2,bounds[1]+(492-thumb.height)//2))
    else:
        large=mark.copy();large.thumbnail((360,380),Image.Resampling.LANCZOS)
        im.paste(large,(950-large.width//2,313-large.height//2),large)
    d=ImageDraw.Draw(im)
    mini=mark.copy();mini.thumbnail((102,102),Image.Resampling.LANCZOS)
    im.paste(mini,(69,47),mini)
    d.text((191,71),'GAURIKRIT',font=ImageFont.truetype(BOLD,28),fill='#173F2B')
    d.text((70,266),line1,font=fit_font(d,line1,620),fill='#173F2B')
    d.text((70,350),line2,font=fit_font(d,line2,620),fill='#173F2B')
    d.line((70,515,650,515),fill='#A38A54',width=2)
    d.text((70,537),'Good for Nature. Good for Life.',font=ImageFont.truetype(FONT,22),fill='#365746')
    im.save(ASSETS/'social'/f'og-{slug}.jpg',quality=88,optimize=True,progressive=True)

print('Prepared brand, product, brochure, illustration, favicon and ten OG assets.')
