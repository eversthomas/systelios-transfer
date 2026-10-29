---
name: theme-pruefen
description: Prüfroutine vor Abschluss jeder Phase – Code-Durchsicht auf Sicherheit, Escaping, Barrierefreiheit, Tokens und Planabgleich; erzeugt eine kurze Testliste für Tom.
---

# Theme prüfen

## 1. Code-Durchsicht (selbst ausführen)
- [ ] `php -l` über alle geänderten PHP-Dateien
- [ ] Jede Ausgabe escaped? (`echo` ohne `esc_*`/`wp_kses_post` suchen)
- [ ] Jede Formular-/Admin-Aktion mit Nonce **und** Capability?
- [ ] Alle Eingaben sanitisiert, Optionen mit `sanitize_callback`?
- [ ] Keine Hex-Farben außerhalb von `haus.css`/`familie.css`/`theme.json`
- [ ] Keine externen URLs zu Fonts/CDNs; kein jQuery-Handle in Abhängigkeiten
- [ ] Präfix `stt_` überall, Text-Domain `systelios-transfer`
- [ ] Keine Referenz auf `docs/`, `referenz/`, `inhalte/`, `.cursor/` im Theme-Code
- [ ] `// ENTSCHEIDUNG D<n>:`-Stellen aufgelistet

Wenn verfügbar zusätzlich: `vendor/bin/phpcs --standard=WordPress` auf geänderte Dateien.

## 2. Abgleich mit dem Plan
- Abnahmekriterien der Phase aus `docs/06-umsetzungsplan.md` einzeln abhaken.
- Abweichungen benennen und begründen.

## 3. Ausgabe für Tom
Kurze Liste:
1. Was gebaut wurde (Dateien)
2. Was er lokal testen soll – passende Punkte aus `docs/07-testplan.md` plus „Immer“
3. Offene Entscheidungen, die diese Phase betreffen
