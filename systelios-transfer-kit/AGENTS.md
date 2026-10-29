# AGENTS.md – sysTelios TRANSFER Theme

Du baust ein **klassisches WordPress-Theme** (PHP-Templates, kein Block-/FSE-Theme) für
systelios-transfer.de. Es ersetzt ein Elementor-Setup. Inhalte werden im **Block-Editor**
gepflegt – mit Leitplanken über `theme.json`, eine Block-Auswahl und Block-Muster.

## Lies zuerst (in dieser Reihenfolge)

1. `docs/01-konzept.md` – Ziel, Rahmen, was das Theme *nicht* tut
2. `docs/02-designsystem.md` – Tokens, Familienregeln, Komponenten
3. `docs/03-pflegekonzept.md` – wie 2–3 Redakteur*innen damit arbeiten
4. `docs/04-inhalte-und-fallback.md` – bestehende Inhalte als veränderbarer Fallback
5. `docs/05-familie-newsletter-lernreise-seo.md` – Verbindung zu LEBENSART
6. `docs/06-umsetzungsplan.md` – Phasen mit Abnahmekriterien
7. `docs/07-testplan.md`, `docs/08-entscheidungen.md`

## Grundsätze

- **Komplex ist nicht kompliziert.** Die Pflege durch mehrere Menschen ist komplex; die
  Technik soll einfach bleiben: wenige Regeln, gute Voreinstellungen, fehlerfreundlich.
- **Kein Page-Builder, keine Feld-Plugins, kein jQuery, kein Build-Schritt.**
  Reines PHP, CSS mit Custom Properties, wenig Vanilla-JS.
- **Theme = Darstellung.** Daten (Begleiter*innen, Angebote/Termine) kommen per Shortcode
  aus dem vorhandenen Plugin BSEasy Sync. Das Theme stellt sie nur dar und gibt ihnen
  über CSS-Variablen das passende Aussehen. Den Plugin-Code nicht verändern.
- **Fallback statt Migrationsrisiko.** Jede bekannte Seite funktioniert sofort nach dem
  Theme-Wechsel mit mitgelieferten Mustern und lässt sich später per Knopf in den Editor
  übernehmen (siehe Doku 04).
- **Familienähnlichkeit zu sysTelios LEBENSART** über gemeinsame Konstanten
  (Schrift, Skala, Raster, Verhalten, Familienmodul) – eigene Hausfarbe und Formsprache.
- **Barrierefreiheit (WCAG 2.2 AA) und Sicherheit** sind Abnahmekriterien, keine Kür.

## Arbeitsweise

- Arbeite **Phase für Phase** nach `docs/06-umsetzungsplan.md`. Nach jeder Phase: anhalten,
  kurz zusammenfassen, Testpunkte aus `docs/07-testplan.md` nennen.
- Bei Unklarheit: Voreinstellung aus `docs/08-entscheidungen.md` nehmen, Stelle mit
  `// ENTSCHEIDUNG D<n>:` kommentieren, weitermachen.
- Präfix für Funktionen, Hooks, Optionen, Meta-Keys: `stt_` / `_stt_`.
  Text-Domain: `systelios-transfer`. CSS-Klassen: deutsch und sprechend (`.seitenkopf`,
  `.familienleiste`), BEM-artig wie im LEBENSART-Theme.
- Code-Kommentare und Admin-Texte auf **Deutsch**, Anrede **„Sie“** im Frontend,
  Gendern mit **Sternchen** (Klient*innen, Begleiter*innen).
- Werte niemals aus dem Entwurf (`referenz/entwurf/*.dc.html`) per Inline-Style übernehmen –
  der Entwurf zeigt *Werte*, das Theme setzt sie über Tokens und Klassen um.

## Nicht tun

- Keine Inhalte von LEBENSART kopieren (doppelter Inhalt schadet beiden Seiten).
- Keine Google Fonts oder andere externe Ressourcen laden (DSGVO) – Schriften liegen lokal.
- Keine Elementor-Daten löschen (`_elementor_*`-Meta bleibt unangetastet, damit alles
  umkehrbar ist).
- Keine Datei- oder Code-Editoren im Backend, kein `eval`, keine Uploads außerhalb der
  Mediathek (Sicherheitsvorfall 07/2026 – siehe Doku 01).
