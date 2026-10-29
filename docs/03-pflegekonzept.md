# 03 – Pflegekonzept

**Rahmen:** 2–3 Redakteur*innen, eher regelmäßig. Deshalb *leichte* Leitplanken:
wenig Auswahl, klare Bausteine, alles zurücknehmbar. Kein Freigabe-Workflow.

## 1. Was Redakteur*innen pflegen – und wo

| Was | Wo im Backend | Technik |
|---|---|---|
| Seitentitel = H1 | Seite → Titel | WordPress-Standard |
| Einleitung im Seitenkopf | Seite → **Textauszug** | `add_post_type_support('page','excerpt')`; Feld im Editor umbenennen: „Einleitung (Seitenkopf)“ |
| Bildband im Seitenkopf | Seite → **Beitragsbild** | optional; ohne Bild kein Band |
| Seiteninhalt | Block-Editor | erlaubte Blöcke + Muster |
| Startseite | Block-Editor | **ein** gesperrtes Gesamtmuster (`templateLock: contentOnly`) |
| Kontaktfläche, Heilkunde-Hinweis | **Synchronisierte Muster** | einmal ändern, wirkt überall |
| Menüs | Design → Menüs | Positionen `haupt`, `fuss` |

Nur der Admin (Tom) pflegt: Theme-Einstellungen (Newsletter, Lernreise, Familie, Kontakt-E-Mail).

## 2. Erlaubte Blöcke

Filter `allowed_block_types_all` (für alle Rollen außer Administrator *identisch* – Tom soll
sehen, was die anderen sehen; ein Admin-Schalter „alle Blöcke“ ist nicht nötig):

`core/paragraph`, `core/heading` (nur H2–H4, siehe unten), `core/list`, `core/list-item`,
`core/image`, `core/quote`, `core/buttons`, `core/button`, `core/separator`, `core/group`,
`core/columns`, `core/column`, `core/media-text`, `core/details`, `core/file`,
`core/shortcode`, `core/block` (synchronisierte Muster), `core/pattern`.

- **H1 nur aus dem Titel.** Überschriften-Block auf H2–H4 begrenzen
  (`levelOptions` per `block_type_metadata`-Filter oder `register_block_type_args`).
- Block-Verzeichnis, Remote-Muster, Core-Muster abschalten:
  `remove_action('enqueue_block_editor_assets','wp_enqueue_editor_block_directory_assets')`,
  `add_filter('should_load_remote_block_patterns','__return_false')`,
  `remove_theme_support('core-block-patterns')`.
- Keine freien Farben, Schriftgrößen, Abstände, Ränder (siehe `referenz/theme.json`).
  Variation erfolgt über **Block-Stile**.

## 3. Block-Stile (statt Farbwähler)

| Block | Stil-Name | Wirkung |
|---|---|---|
| `core/group` | `warm` „Warmes Band“ | volle Breite, `--flaeche-warm` |
| `core/group` | `dunkel` „Dunkles Band“ | volle Breite, `--flaeche-dunkel`, helle Schrift |
| `core/group` | `karte` „Karte“ | Rand `--linie`, Radius 24, Innenabstand 32 |
| `core/group` | `akzent` „Akzentfläche“ | `--haus`, Radius 28 (für Kontaktfläche) |
| `core/button` | Standard = primär (Orange) · `umriss` · `dunkel` | |
| `core/image` | Standard = Radius 24 · `eckig` (falls Plugin-/Logobilder) | |
| `core/quote` | `punkte` „Zitat mit Punkten“ | Cormorant, Punkte-Cluster |
| `core/list` | `haken` / `nummern-gross` | Leitsätze („Auf den Punkt“) |
| `core/paragraph` | `lead` „Einleitung“, `hinweis` „Hinweis“ | |

## 4. Muster (Inserter-Kategorie „Transfer“)

Dateien in `patterns/`, Kopf mit `Title`, `Slug: stt/…`, `Categories: stt-transfer`.

| Slug | Titel im Editor | Aufbau |
|---|---|---|
| `stt/text-mit-bild` | Text mit Bild | Spalten 60/40, H2 + Absätze + Bild |
| `stt/warmes-band` | Warmes Band mit Text und Bild | Gruppe `warm` + Text mit Bild |
| `stt/drei-karten` | Drei Karten | Spalten, je Gruppe `karte` mit Punkt, H3, Text, Link |
| `stt/prinzipien` | Prinzipien (4 Karten) | wie Entwurf „In der Praxis“ |
| `stt/auf-den-punkt` | Auf den Punkt | Gruppe `dunkel`, H2, Liste `nummern-gross` |
| `stt/zitat` | Zitat mit Punkten | Zitat `punkte` |
| `stt/sprungleiste` | Sprungleiste „Auf dieser Seite“ | Gruppe `warm` klein + Liste mit Ankerlinks |
| `stt/regionale-liste` | Regionale Übersicht (PLZ-Bereich) | H2 mit Anker + Liste/Datei-Blöcke; für Gruppen vor Ort & Angehörige |
| `stt/familienhinweis` | Hinweis aus der Familie | siehe Doku 05 |
| `stt/lernreise-teaser` | Lernreise (LEBENSART) | siehe Doku 05 |
| `stt/verzeichnis` | Verzeichnis Begleiter*innen | Shortcode-Block mit BSEasy-Sync-Shortcode |
| `stt/termine-transferabend` | Termine Transferabend | Shortcode-Block |
| `stt/startseite` | Startseite (gesamt) | `Inserter: no`; Gruppe mit `templateLock: contentOnly` |
| `stt/inhalt-<slug>` | Fallback-Inhalt je Seite | `Inserter: no`; siehe Doku 04 |

Synchronisierte Muster (werden von der Einrichtung als `wp_block` angelegt, falls nicht
vorhanden, erkennbar an Meta `_stt_kennung`): **Kontaktfläche „Ins Gespräch kommen“**,
**Hinweis Heilkunde**.

## 5. Rollen und Sicherheit

- Redakteur*innen: Rolle **Redakteur** (`editor`). Admin nur Tom.
- `DISALLOW_FILE_EDIT` in der Doku zur Live-Schaltung empfehlen (gehört in `wp-config.php`,
  nicht ins Theme).
- Revisionen aktiv lassen (Standard). Optional begrenzen: `WP_POST_REVISIONS` = 20.

## 6. Hilfe direkt im Backend

Admin-Seite **„So pflegen Sie Transfer“** (Menüpunkt unter Dashboard, sichtbar für
`edit_pages`). Inhalt: kurze Abschnitte mit den Mustern, Textauszug = Einleitung,
Beitragsbild = Bildband, Startseite nur Inhalt, synchronisierte Muster, Revisionen.
Text als statisches PHP-Template `inc/admin/hilfe.php` – keine Datenbank.

## 7. Editor = Frontend

`add_theme_support('editor-styles')` + `add_editor_style()` mit `familie.css`, `haus.css`,
`bloecke.css`, damit Schriften, Farben, Radien und Block-Stile im Editor wie auf der Seite
aussehen. Schriften im Editor ebenfalls lokal.
