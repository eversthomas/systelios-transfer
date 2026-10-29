# 07 – Testplan (lokal)

Empfohlene Hilfen: Plugin **Query Monitor** (PHP-Hinweise, Hooks), **Theme Check**,
Browser-DevTools/Lighthouse, ein Screenreader (VoiceOver/NVDA), Benutzer mit Rolle *Redakteur*.

## Immer (nach jeder Phase)
- [ ] Keine PHP-Warnungen/-Hinweise (Query Monitor), keine Konsolenfehler
- [ ] 320px Breite: kein horizontales Scrollen; 200 % Zoom: nichts abgeschnitten
- [ ] Nur mit Tastatur bedienbar, Fokus immer sichtbar, Reihenfolge logisch
- [ ] Genau eine H1 pro Seite, keine Überschriftensprünge
- [ ] Kontrast: Text ≥ 4,5:1, Bedienelemente/Feldränder ≥ 3:1
- [ ] Keine externen Requests (Netzwerk-Tab: keine Google Fonts, keine CDNs)
- [ ] `prefers-reduced-motion`: keine Bewegungen

## Phase 1
- [ ] Startseite, alle Unterseiten, 404, Suche laden
- [ ] Menü: Hover/aktiv mit 3px-Unterstrich; mobil Punkte-Knopf öffnet/schließt, Escape schließt
- [ ] Seitenkopf: Titel, Einleitung (Textauszug), Bildband (Beitragsbild) bzw. ohne Bild sauber

## Phase 2
- [ ] Als Redakteur: nur erlaubte Blöcke, keine Farben/Größen/Abstände, H1 nicht wählbar
- [ ] Block-Verzeichnis und Core-Muster nicht sichtbar
- [ ] Editor-Darstellung = Frontend (Schrift, Farben, Radien)

## Phase 3
- [ ] Jedes Muster einfügen, Texte ändern, speichern, Frontend prüfen
- [ ] Startseite: Texte/Bilder änderbar, Abschnitte nicht verschieb-/löschbar
- [ ] Synchronisiertes Muster an einer Stelle ändern → überall geändert

## Phase 4 (Kernstück)
- [ ] Theme frisch aktivieren: **alle** Seiten aus `inhalte/index.json` vollständig im neuen Design
- [ ] Verzeichnis- und Termin-Shortcodes erscheinen an der richtigen Stelle
- [ ] Interne Links und Bilder funktionieren lokal (keine Live-URLs fest verdrahtet)
- [ ] Editor-Hinweis erscheint auf Fallback-Seiten; „Inhalt übernehmen“ → Inhalt im Editor, Revision vorhanden
- [ ] „Auf Fallback zurückstellen“ → Frontend zeigt wieder das Muster
- [ ] „Alle übernehmen“ mit Bestätigungsschritt
- [ ] Elementor-Meta (`_elementor_data`, `_elementor_edit_mode`) nach allen Aktionen unverändert
- [ ] Ohne Berechtigung/Nonce: Aktionen verweigert

## Phase 5
- [ ] Einstellungen speichern, Sonderzeichen/HTML werden sauber behandelt
- [ ] Familienleiste: Häuser ohne Link als Text, Transfer markiert, Reihenfolge wie LEBENSART
- [ ] Newsletter-Hinweis nur bei gesetzter URL; Link öffnet LEBENSART
- [ ] Lernreise-Seite + Startseiten-Karte + Familienhinweise verlinken auf `stt_lernreise_url`
- [ ] Verzeichnis wirkt im Transfer-Design (Farben, Radien, Schrift), Filter bedienbar
- [ ] Kontaktformular nach D3: Pflichtfelder, Fehlermeldungen zugänglich, Honeypot, Mail kommt an
- [ ] JSON-LD standardmäßig aus; eingeschaltet valide (Rich-Results-Test) und kein Doppel mit SEO-Plugin

## Phase 6
- [ ] Dark Mode (Systemeinstellung umschalten): alle Seiten lesbar, Logo sichtbar
- [ ] Lighthouse mobil: Performance ≥ 90, Barrierefreiheit ≥ 95, Best Practices ≥ 95, SEO ≥ 95
- [ ] Druckvorschau einer Inhaltsseite lesbar
