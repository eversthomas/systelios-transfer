# tools/

## export-inhalte.php

Liest die bestehenden Seiten aus und legt sie als Ausgangsmaterial für die Fallback-Muster
in `inhalte/` ab. **Schreibt nichts in die Datenbank.**

```bash
# im WordPress-Hauptverzeichnis der lokalen Kopie
wp eval-file wp-content/themes/systelios-transfer/tools/export-inhalte.php

# anderer Zielordner
wp eval-file wp-content/themes/systelios-transfer/tools/export-inhalte.php /pfad/zum/ordner
```

- **Elementor muss nicht aktiv sein.** Die Struktur wird direkt aus `_elementor_data` gelesen
  (Überschriften, Texte, Bilder mit Anhang-ID, Buttons, Listen, Shortcode-Widgets,
  Galerien, Akkordeons, Formularfelder, HTML-Widgets; Unbekanntes wird als Hinweis gesichert).
  Ist Elementor aktiv, liegt zusätzlich `<slug>.elementor.html` (gerendert) zum Vergleich daneben.
- Shortcodes werden auch erkannt, wenn das zugehörige Plugin lokal nicht aktiv ist.
- Seiten, die schon aus Blöcken bestehen, bekommen zusätzlich `<slug>.bloecke.html`.

### Ergebnis
| Datei | Inhalt |
|---|---|
| `index.json` | alle Seiten: id, slug, pfad, titel, status, eltern, startseite, elementor, excerpt, thumbnail_id, shortcodes, widgets, bilder, hinweise |
| `<slug>.html` | bereinigtes Inhalts-HTML (nur veröffentlichte Seiten) |
| `menus.json` | Menüs, Menüpunkte, Positionen |
| `site.json` | Startseite, Titel, Logo, aktive Plugins |

Getestet mit WordPress 7.x (Entwicklungsstand) und PHP 8.3, mit nachgebildeten Elementor-Daten.
Bei echten Live-Daten können weitere Widget-Typen auftauchen – sie erscheinen in `hinweise`
als „Unbekanntes Widget“ und ihre Texte werden trotzdem gesichert.
