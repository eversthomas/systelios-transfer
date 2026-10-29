# sysTelios TRANSFER – Theme-Kit für Cursor

Dieses Paket enthält alles, was Cursor braucht, um das neue klassische WordPress-Theme
für **systelios-transfer.de** zu bauen: Konzept, Designsystem, Pflegekonzept, Regeln,
Skills, Referenzen und ein Export-Skript für die bestehenden Inhalte.

## So benutzt du das Kit

1. **Neuen Theme-Ordner anlegen**, z. B. `wp-content/themes/systelios-transfer/`, und den
   *Inhalt* dieses Kits hineinkopieren (inkl. der versteckten Ordner `.cursor/`).
   Die Ordner `docs/`, `referenz/`, `tools/`, `inhalte/` und `.cursor/` werden später
   beim Ausliefern nicht mit hochgeladen (siehe `docs/06-umsetzungsplan.md`, Phase 7).
2. **Lokale Kopie der Live-Seite** bereitstellen (Datenbank + `wp-content/uploads`), damit
   Inhalte, Medien und Plugins (u. a. BSEasy Sync) wie live vorhanden sind.
   Achtung: Nur eine Kopie aus dem bereinigten Zustand nach dem Sicherheitsvorfall verwenden.
3. **Inhalte exportieren** (einmalig, vor Phase 4):
   ```bash
   wp eval-file wp-content/themes/systelios-transfer/tools/export-inhalte.php
   ```
   Das Skript schreibt die aktuellen Seiteninhalte nach `inhalte/`. Details: `tools/README.md`.
4. **Cursor öffnen** im Theme-Ordner und mit folgendem Auftrag starten:
   > Lies AGENTS.md und docs/06-umsetzungsplan.md. Beginne mit Phase 1. Arbeite Phase für
   > Phase, halte nach jeder Phase an und fasse zusammen, was ich lokal testen soll.
5. **Nach jeder Phase lokal testen** – die Prüfpunkte stehen in `docs/07-testplan.md`.

## Was wo liegt

| Ort | Inhalt |
|---|---|
| `AGENTS.md` | Einstieg für Cursor: Ziel, Grenzen, Arbeitsweise |
| `.cursor/rules/` | Projektregeln (werden je nach Datei automatisch geladen) |
| `.cursor/skills/` | Abläufe: Inhalt → Muster, Theme prüfen |
| `docs/` | Konzept, Designsystem, Pflege, Inhalte/Fallback, Familie & SEO, Plan, Tests, Entscheidungen |
| `referenz/entwurf/` | Der abgestimmte visuelle Entwurf (3 Seiten) |
| `referenz/lebensart/` | Auszüge aus dem LEBENSART-Theme (CSS, Familienmodul, Schriften) |
| `referenz/*.css`, `referenz/theme.json` | Entwürfe für Tokens, Familienfundament und theme.json |
| `tools/export-inhalte.php` | Export der bestehenden Inhalte als Fallback-Grundlage |
| `inhalte/` | Zielordner des Exports; Ausgangsmaterial für die Fallback-Muster |

## Offene Entscheidungen

Stehen gesammelt in `docs/08-entscheidungen.md`. Cursor arbeitet mit den dort genannten
Voreinstellungen weiter und markiert die Stellen, falls du anders entscheidest.
