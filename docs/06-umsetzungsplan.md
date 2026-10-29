# 06 – Umsetzungsplan

Arbeite Phase für Phase. Nach jeder Phase: anhalten, zusammenfassen, Testpunkte aus
`07-testplan.md` nennen. Offene Punkte → `08-entscheidungen.md` (Voreinstellung nehmen).

## Zielstruktur

```
systelios-transfer/
├── style.css                  Theme-Kopf (Name, Version, Requires at least 6.6, PHP 8.1, Text Domain)
├── functions.php              nur require_once der inc/-Dateien
├── theme.json                 aus referenz/theme.json
├── screenshot.png             1200×900
├── header.php · footer.php · index.php · page.php · front-page.php · 404.php · search.php
├── template-parts/
│   ├── seitenkopf.php         Brotkrumen, H1, Einleitung, Bildband
│   ├── menue-mobil.php        Vollbild-Menü
│   ├── familienleiste.php
│   └── newsletter-hinweis.php
├── inc/
│   ├── config.php             stt_fallback_karte(), stt_shortcodes(), Konstanten
│   ├── setup.php              Supports, Menüs, Bildgrößen, Textauszug für Seiten
│   ├── assets.php             CSS/JS/Fonts, Preload, Editor-Styles
│   ├── editor.php             erlaubte Blöcke, H2–H4, Abschalten Verzeichnis/Remote-Muster
│   ├── bloecke.php            register_block_style()
│   ├── muster.php             Kategorie „Transfer“, synchronisierte Muster anlegen, stt_sync_muster_id( $kennung )
│   ├── inhalte.php            Fallback-Logik (Zustände, Rendering)
│   ├── familie.php            stt_familie_daten(), stt_familienleiste()
│   ├── shortcodes.php         [stt_familie] [stt_newsletter] [stt_lernreise_button]
│   ├── seo.php                optionales JSON-LD (Standard aus)
│   ├── plugin-bseasy.php      Erkennung + CSS-Variablen für das Verzeichnis
│   └── admin/
│       ├── einstellungen.php  Design → Transfer-Einstellungen (Settings API)
│       ├── inhalte.php        Design → Transfer-Inhalte (Übernehmen)
│       └── hilfe.php          „So pflegen Sie Transfer“
├── patterns/                  Muster (Doku 03) + inhalt-<slug>.php (Doku 04)
└── assets/
    ├── css/  familie.css · haus.css · layout.css · komponenten.css · bloecke.css · plugin-bseasy.css
    ├── js/   menue.js · editor-hinweis.js
    ├── fonts/
    └── img/  logo (SVG, siehe D8), Platzhalter
```

Nicht ausgeliefert (nur Entwicklung): `docs/ referenz/ tools/ inhalte/ .cursor/ AGENTS.md README.md`.

---

## Phase 0 – Vorbereitung (Tom)
- Lokale Kopie der Live-Seite (DB + uploads), Elementor **deaktiviert**, BSEasy Sync aktiv.
- `wp eval-file …/tools/export-inhalte.php` → `inhalte/` gefüllt.
- Shortcodes von BSEasy Sync in `docs/08-entscheidungen.md` (D2) eintragen.

## Phase 1 – Grundgerüst
- `style.css`, `functions.php`, `theme.json`, `inc/setup.php`, `inc/assets.php`.
- Schriften lokal, `familie.css` + `haus.css` aus `referenz/`, `layout.css`.
- `header.php` (Skip-Link, Kopfleiste 68px, Logo, Menü `haupt`, Punkte-Menüknopf),
  `menue-mobil.php` + `menue.js` (`aria-expanded`, Escape schließt, Fokus bleibt im Menü,
  `inert` auf Rest), `footer.php` (dunkel, Claim, Menü `fuss`, Copyright).
- `page.php` + `seitenkopf.php` (Titel, Textauszug, Beitragsbild), `index.php`, `404.php`, `search.php`.
- `front-page.php` vorerst: Inhalt der Startseite ausgeben.

**Abnahme:** Alle Seiten laden ohne PHP-Hinweise, Menü per Tastatur bedienbar,
320px ohne horizontales Scrollen, Seitenkopf zeigt Titel/Einleitung/Bild.

## Phase 2 – Editor und Leitplanken
- `inc/editor.php`, `inc/bloecke.php`, `bloecke.css`, Editor-Styles.
- Textauszug-Feld als „Einleitung (Seitenkopf)“ beschriften.

**Abnahme:** Als Redakteur nur die erlaubten Blöcke, keine Farb-/Größenwähler, H1 nicht
wählbar, Editor sieht aus wie Frontend, Block-Stile sichtbar.

## Phase 3 – Muster
- Alle allgemeinen Muster aus Doku 03 (ohne `inhalt-*`), Kategorie „Transfer“.
- Synchronisierte Muster „Ins Gespräch kommen“ und „Hinweis Heilkunde“ bei Theme-Aktivierung
  (`after_switch_theme`) und per Knopf in Transfer-Inhalte anlegen – nur wenn nicht vorhanden.
- `stt/startseite` (gesperrt, `templateLock: contentOnly`) nach `referenz/entwurf/Main.dc.html`,
  Texte aus `inhalte/` (Startseite). Suchleiste nach D5.

**Abnahme:** Muster einfügbar, Startseiten-Muster nur inhaltlich editierbar, synchronisierte
Muster wirken an allen Stellen.

## Phase 4 – Fallback-System und Fallback-Inhalte
- `inc/inhalte.php` (Zustände nach Doku 04), `inc/admin/inhalte.php`, `editor-hinweis.js`.
- Für jede Seite aus `inhalte/index.json` (außer Impressum/Datenschutz, siehe D9):
  `patterns/inhalt-<slug>.php` mit dem Skill `inhalt-zu-muster`.
- `inc/config.php` → `stt_fallback_karte()` vollständig.
- `front-page.php`: Fallback `stt/startseite`, sonst Inhalt.

**Abnahme:** Frisch aktiviertes Theme zeigt alle Seiten vollständig; Übernehmen erzeugt
editierbaren Inhalt + Revision; Zurückstellen funktioniert; Elementor-Meta unverändert.

## Phase 5 – Familie, Newsletter, Lernreise, Einstellungen, Plugin, Kontakt
- `inc/admin/einstellungen.php`: Newsletter, Lernreise-URL, Kontakt-E-Mail, Familie (8 Zeilen),
  JSON-LD-Schalter.
- `inc/familie.php`, `inc/shortcodes.php`, `familienleiste.php`, `newsletter-hinweis.php`.
- Muster `familienhinweis`, `lernreise-teaser`, Seite/Muster `inhalt-lernreise`.
- `inc/plugin-bseasy.php` + `plugin-bseasy.css`: Verzeichnis und Termine über Variablen an
  Haus-Tokens anbinden (nur CSS, Plugin-Code unberührt). Liste der Variablen, die das
  Plugin auslesen sollte, als Kommentar in der CSS-Datei.
- Hilfe-Seite „So pflegen Sie Transfer“.
- Kontaktformular nach D3.

**Abnahme:** Siehe Testplan Phase 5.

## Phase 6 – Feinschliff
- Dark Mode nach D4 (`prefers-color-scheme`), Kontraste geprüft.
- Performance: nur nötige CSS/JS je Seite, Bilder mit `sizes`, Fonts-Preload.
- Barrierefreiheits-Durchgang (Testplan „Immer“), Druckansicht für Inhaltsseiten (einfach).

## Phase 7 – Auslieferung
- ZIP ohne Entwicklungsordner (Skript `tools/paket.sh` oder Anleitung).
- Checkliste Live-Umstellung in `docs/09-live-umstellung.md` schreiben:
  Backup → Theme hochladen → Elementor deaktivieren (nicht löschen) → Theme aktivieren →
  Menüs zuweisen → Seiten prüfen → Übernehmen nach Bedarf → nach 4 Wochen Elementor löschen.
