# 02 – Designsystem

Visuelle Referenz: `referenz/entwurf/Main.dc.html` (Startseite), `Hypnosystemik.dc.html`
(Inhaltsseite), `Begleiter.dc.html` (Verzeichnis). Die Dateien enthalten Inline-Styles –
sie zeigen **Werte und Aufbau**, nicht die Umsetzung.

## 1. Familienregeln (gilt für TRANSFER *und* LEBENSART)

Wittgensteins „Familienähnlichkeit“: nicht ein gemeinsames Merkmal, sondern sich
überlappende Ähnlichkeiten.

### Familienkonstanten – identisch auf beiden Seiten
| Bereich | Regel |
|---|---|
| Schrift | **Barlow** (300–700, normal + kursiv), lokal gehostet |
| Überschriften | H1/H2/H3 **fett, kursiv**, `letter-spacing: -0.01em`, `padding-bottom: .08em` |
| Zitate/Impulse | **Cormorant Garamond** 500 (LEBENSART: Impulskarten; TRANSFER: Zitat-Muster) |
| Größenskala | wie LEBENSART: Body 1.125rem/1.6, H1 `clamp(2.5rem,4.6vw,4.5rem)`, H2 `clamp(2rem,3.4vw,3rem)`, H3 1.375rem, Lead `clamp(1.1875rem,1.6vw,1.375rem)` |
| Raster | `--max: 1280px`, `--pad: clamp(1rem,4vw,3rem)`, Sektionen `padding-block: clamp(3.5rem,8vw,7rem)` |
| Kopfleiste | Höhe **68px**, Logo links, Menü rechts, aktive Seite mit **3px-Unterstrich** in Hausfarbe, sticky |
| Buttons | Mindesthöhe 52px (klein 44px), Schrift 600 / 1.0625rem, Hover: `translateY(-2px)` + weicher Schatten, Pfeil wandert 4px |
| Links | Unterstrich 1.5px, Hover 3px, `text-underline-offset: .2em` |
| Fokus | `outline: 3px solid var(--fokus); outline-offset: 3px` |
| Bewegung | Easing `cubic-bezier(.16,1,.3,1)`, `prefers-reduced-motion` respektieren |
| Familienleiste | gleiches Modul, gleiche Daten, gleiche Reihenfolge; eigenes Haus markiert |
| Sprache | „Sie“, Gendern mit `*`, „Klient*innen“ (nicht „Patient*innen“) |

### Gleiche Regel, eigenes Ergebnis
| Regel | LEBENSART | TRANSFER |
|---|---|---|
| Formsprache aus dem Logo-Motiv | Dreieck/Netz → **eckig** (Flächen 0, Bedienelemente 4px) | Kreise/Punkte → **rund** (Flächen 24–28px, Buttons/Tags 999px) |
| Menüknopf aus dem Logo | drei Ballons | **Punkte** aus dem Transfer-Logo |
| Eine volle Akzentfläche pro Seite für die wichtigste Handlung | Spendenband (Gelb) | „Ins Gespräch kommen“ (Orange) |
| Hausfarbe als Punkt | Familienleiste | Familienleiste, Familienhinweise, Augenbraue über H1 |

### Hausmerkmale – bewusst verschieden
- TRANSFER ist **ruhiger Wegweiser** (Suche, Verzeichnis, Angebote), keine Bühne:
  kein bildschirmfüllender Hero, kein Netz-Canvas, keine Einblend-Animationen.
- Farben: Orange + Grau aus dem Logo, warmes Creme für Bänder.

## 2. Tokens

Rollen-Namen sind **für beide Häuser gleich**; nur die Werte unterscheiden sich.
Datei-Entwurf: `referenz/tokens.css` (Hauswerte) und `referenz/familie.css` (Konstanten).

| Rolle | Variable | TRANSFER hell | Hinweis |
|---|---|---|---|
| Hausfarbe (Fläche, Punkte) | `--haus` | `#F6A500` | Logo; **nie als Textfarbe auf Weiß** (2,1:1) |
| Text auf Hausfarbe | `--auf-haus` | `#1F2A2F` | 7,8:1 |
| Hausfarbe als Text/Link | `--haus-text` | `#8F5600` | 6,0:1 auf Weiß |
| Hover Link | `--haus-text-hover` | `#6B4000` | |
| Markengrau | `--marke-grau` | `#6F6E6E` | Logo-Schriftzug, nur dekorativ/groß |
| Überschriften | `--ueberschrift` | `#4D5A62` | 7,6:1 |
| Fließtext | `--tinte` | `#2F3A40` | |
| Text gedämpft | `--tinte-leise` | `#5E6B72` | ≥ 4,5:1 auch auf Creme |
| Grund | `--grund` | `#FFFFFF` | |
| Warme Fläche | `--flaeche-warm` | `#FCF6EB` | Bänder, Filter, Sprungleiste |
| Dunkle Fläche | `--flaeche-dunkel` | `#3A454C` | „Auf den Punkt“, Fußzeile |
| Linie | `--linie` | `#E9DFCC` | Karten, Trenner |
| Feldrand | `--feld-rand` | `#9C8B63` | Formulare, 3,3:1 zu Weiß (WCAG 1.4.11). Der Entwurf nutzt noch `#CDBF9F` – das ist zu schwach (1,8:1) |
| Fokus | `--fokus` | `#4D5A62` | |
| Radius Fläche | `--radius-flaeche` | `28px` (Bilder, Bänder), Karten `24px` | |
| Radius Bedienelement | `--radius-bedien` | `999px` | Buttons, Tags, Segmente |
| Radius Feld | `--radius-feld` | `12px` | Inputs, Selects |

Dark Mode (Phase 6, `prefers-color-scheme: dark`): Werte in `referenz/tokens.css` als
Vorschlag; jede Kombination auf 4,5:1 prüfen.

Abbildung auf LEBENSART (für eine spätere Angleichung dort, **nicht Teil dieses Projekts**):
`--yellow → --haus`, `--on-yellow → --auf-haus`, `--teal-ink → --ueberschrift`,
`--link → --haus-text` (LEBENSART nutzt Petrol als Text), `--bg → --grund`, `--tint → --flaeche-warm`,
`--line → --linie`, `--r → --radius-bedien`.

## 3. Komponenten (aus dem Entwurf)

| Komponente | Wo | Kern |
|---|---|---|
| **Kopfleiste** | überall | 68px, sticky, Logo 132px breit, Menü, Punkte-Menüknopf < 1060px, Vollbild-Menü mobil in `--flaeche-dunkel` |
| **Seitenkopf** | alle Unterseiten | Brotkrumen, H1 (= Seitentitel), Lead (= Textauszug), optional Bildband 240px hoch (= Beitragsbild), keine Farbfläche |
| **Startseiten-Einstieg** | Startseite | Augenbraue mit 3 Punkten, H1, Lead, 2 Buttons; rechts Bild 400px hoch, Radius 28 |
| **Suchleiste** | Startseite | Creme-Fläche: Ort/PLZ, Angebot, „auch online“, Button → Verzeichnisseite mit Query-Parametern (siehe D5) |
| **Einstiegskarten** | Startseite | 3er-Raster, Kreis-Icon in Hausfarbe, H3, Text, „Mehr →“ |
| **Text mit Bild** | Inhalt | 2 Spalten, umbrechend, Bild Radius 24–28 |
| **Warmes Band** | Inhalt | volle Breite `--flaeche-warm`, Inhalt im Raster |
| **Angebotskarte** | Startseite/Angebote | Tag (Creme-Pill), H3, Text, Definitionsliste, Link |
| **Zitat mit Punkten** | Inhalt | Punkte-Cluster + Cormorant-Zitat |
| **Kontaktfläche** | Inhalt (synchronisiert) | volle `--haus`-Fläche, H2, Text, dunkler Button |
| **Auf den Punkt** | Inhalt | dunkle Fläche, nummerierte Leitsätze in 2 Spalten |
| **Prinzipien-Karten** | Inhalt | Karten mit kleinem Punkt, H3, kurzer Text |
| **Sprungleiste** | lange Seiten | Creme-Box „Auf dieser Seite“ mit Ankerlinks |
| **Familienhinweis** | Inhalt | Karte in Farbe/Logo des *anderen* Hauses (siehe Doku 05) |
| **Newsletter-Hinweis** | Fußzeile | Text + Link zu LEBENSART, gelber Familienpunkt |
| **Familienleiste** | Startseite + Fußbereich Kontaktseite | wie LEBENSART `.family-strip`; Punkt je Haus, eigenes Haus markiert, ohne Link wenn keine Website |
| **Verzeichnis (Plugin)** | Begleiter-Seite | nur Styling über Variablen; Vorschlag für Plugin: 3 Hauptfilter + „Weitere Filter“, Segment „Kacheln/Karte“, Karte ohne Straßenadresse |
| **Fußzeile** | überall | dunkel, Claim, Fußmenü, Newsletter-Hinweis, Copyright |

## 4. Schriften

Aus `referenz/lebensart/fonts/` nach `assets/fonts/` übernehmen. Benötigt:
Barlow normal 400/500/600, kursiv 500/700; Cormorant Garamond normal 500, kursiv 500.
**Achtung:** LEBENSART hat kein `barlow-normal-700`. Falls aufrechte fette Überschriften
gebraucht werden (z. B. Fußzeilen-Claim), Schnitt ergänzen oder 600 nutzen.
`@font-face` mit `font-display: swap`; die zwei wichtigsten Schnitte (`barlow-normal-400`,
`barlow-italic-700`) per `<link rel="preload">`.
