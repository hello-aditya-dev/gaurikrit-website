#!/usr/bin/env bun
/**
 * Validate XML well-formedness of all 11 illustration PHP partials.
 * Strips the `<?php ... ?>` header, replaces PHP echo shortcodes with
 * a plain class string, then parses the result as XML.
 */
import { readFileSync, readdirSync } from 'fs';
import { join } from 'path';
import { DOMParser } from '@xmldom/xmldom';

const dir = '/home/z/my-project/dist-hostinger/includes/illustrations';
const files = readdirSync(dir).filter(f => f.endsWith('.php')).sort();

let pass = 0;
let fail = 0;

for (const file of files) {
  const path = join(dir, file);
  let src = readFileSync(path, 'utf8');

  // Strip the `<?php ... ?>` header block (up to and including the first `?>`).
  const phpOpen = src.indexOf('<?php');
  const phpClose = src.indexOf('?>', phpOpen);
  if (phpOpen === -1 || phpClose === -1) {
    console.error(`✗ ${file}: no <?php ... ?> header block found`);
    fail++;
    continue;
  }
  let svg = src.slice(phpClose + 2);

  // Replace PHP echo shortcodes with plain strings (so the SVG is plain XML).
  // `<?= htmlspecialchars($class, ENT_QUOTES) ?>` → `placeholder-class`
  svg = svg.replace(/<\?=\s*htmlspecialchars\([^)]*\)\s*\?>/g, 'placeholder-class');
  // Strip any remaining `<?php ?>` blocks (shouldn't be any, but defensive).
  svg = svg.replace(/<\?[\s\S]*?\?>/g, '');

  // Parse as XML.
  try {
    const doc = new DOMParser().parseFromString(svg, 'image/svg+xml');
    // Check that the root element is <svg>.
    const root = doc.documentElement;
    if (!root || root.nodeName !== 'svg') {
      console.error(`✗ ${file}: root element is <${root?.nodeName ?? 'null'}>, expected <svg>`);
      fail++;
      continue;
    }
    // Check there's at least one <title> for accessibility.
    const titles = root.getElementsByTagName('title');
    if (titles.length === 0) {
      console.warn(`! ${file}: no <title> element found (accessibility)`);
    }
    console.log(`✓ ${file}  (root: <${root.nodeName}>, viewBox: ${root.getAttribute('viewBox')}, ${titles.length} title)`);
    pass++;
  } catch (e) {
    console.error(`✗ ${file}: XML parse error: ${e.message}`);
    fail++;
  }
}

console.log(`\n${pass}/${pass + fail} files validated.`);
if (fail > 0) process.exit(1);
