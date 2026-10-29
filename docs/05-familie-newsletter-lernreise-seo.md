# 05 – Familie, Newsletter, Lernreise, SEO

## 1. Wirkungsfamilie

### Datenmodell (identisch zu LEBENSART)
LEBENSART liefert die Struktur bereits (`referenz/lebensart/familie.php`,
`wirkungsfamilie-knoten.php`). Je Haus:

| Feld | Typ | Beispiel |
|---|---|---|
| `kennung` | slug | `klinik`, `akademie`, `beratung`, `thinktank`, `transfer`, `lebensart` |
| `rolle` | Text | „sysTelios KLINIK“ |
| `zuschreibung` | Text, optional | „Psychosomatik im Odenwald“ |
| `hex` | Farbe | Hausfarbe (Punkt) |
| `textfarbe` | Farbe | Text auf Hausfarbe |
| `link` | URL, optional | **leer = Haus ohne Website → Text ohne Link** |
| `logo` | Anhang-ID, optional | |
| `wir` | bool | nur bei `transfer` = true |

**Werte:** Namen, Reihenfolge, Farben **aus den LEBENSART-Daten übernehmen**
(liegen dort im Must-Use-Plugin; Tom liefert sie, siehe D6). Bis dahin Platzhalter mit
Transfer `#F6A500`, alle anderen `#6F6E6E`.

### Pflege (Stufe 1)
Admin-Seite **Design → Transfer-Einstellungen**, Abschnitt „Wirkungsfamilie“:
feste Tabelle mit **8 Zeilen** (keine JS-Wiederholfelder). Leere Zeilen werden ignoriert.
Gespeichert als eine Option `stt_familie` (Array), sanitisiert (`sanitize_key`,
`sanitize_text_field`, `sanitize_hex_color`, `esc_url_raw`, `absint`).

### Ausgabe
- Shortcode `[stt_familie]` (Leiste) und PHP-Funktion `stt_familienleiste()`.
- Ort: Startseite (im Startseiten-Muster) und Fußbereich der Kontaktseite.
  **Nicht** in jeder Fußzeile – seitenweite Linkblöcke werden von Suchmaschinen abgewertet.
- **Verbundene Anbieter** (Meta Forum Sommercamp, Milton Erickson Institut Heidelberg,
  Augenhöhe) sind *keine* Familienmitglieder: eigene kleine Logo-/Linkleiste unter der
  Familienleiste, im Startseiten-Muster als normale Blöcke (Bilder mit Links) – redaktionell pflegbar.

### Stufe 2 (später, nicht jetzt bauen)
LEBENSART stellt `/wp-json/la/v1/familie` bereit, Transfer liest per `wp_remote_get`,
speichert 24 h im Transient, fällt bei Fehler auf den letzten Stand bzw. die
Einstellungen zurück. Code jetzt so schneiden, dass `stt_familie_daten()` die **einzige**
Stelle ist, die die Daten liefert.

## 2. Gegenseitige Hinweise – Muster „Hinweis aus der Familie“

`patterns/familienhinweis.php`: Karte im Stil `karte`, links Farbpunkt + Name des anderen
Hauses als Augenbraue, H3, Text, Button (Umriss). Die Akzentfarbe der Karte ist die
Farbe des Hauses, **auf das verwiesen wird** (über eine Klasse `ist-haus-lebensart`
o. ä., Farben aus `stt_familie_daten()` als CSS-Variable `--fam-c`).

Vorgesehene Stellen (in den Fallback-Mustern bereits einsetzen):
- Angebote-Übersicht → „Weiterlernen in der Lernreise“ (LEBENSART)
- Startseite → „Hypnosystemik fördern“ (LEBENSART)
- Was ist Hypnosystemik → am Ende Hinweis auf Lernreise

## 3. Newsletter – nur Hinweis

Newsletter gehört **nur LEBENSART**. Transfer zeigt einen Hinweis mit Link, **kein Formular**.

- Einstellungen: `stt_newsletter_ueberschrift`, `stt_newsletter_text`, `stt_newsletter_url`.
- Ausgabe: fester Bereich in der Fußzeile (über dem Fußmenü) + Shortcode `[stt_newsletter]`.
- Ist `stt_newsletter_url` leer, wird nichts ausgegeben.
- Gestaltung: kleiner Farbpunkt in LEBENSART-Farbe, Text „Newsletter von sysTelios LEBENSART“,
  Link-Button. Externer Link ohne `nofollow` (gleiche Familie), mit `rel="noopener"`.

## 4. Lernreise – fester Platz

Die Transfer-Zielgruppe gehört zur Zielgruppe der Lernreise.

- **Eigene Unterseite** `Angebote → Lernreise` (Slug `lernreise`), Fallback-Muster
  `stt/inhalt-lernreise` mit **Platzhaltertexten in eckigen Klammern** – Text schreibt Tom
  bzw. das Team aus Transfer-Sicht. **Keine Texte von LEBENSART kopieren.**
  Aufbau: Seitenkopf · „Für wen aus dem Netzwerk“ · „Wie sie zu Transferabend und Gruppen passt“ ·
  Familienhinweis mit Button „Zur Lernreise bei LEBENSART“.
- **Startseite**: vierte Angebotskarte „Lernreise“ mit Tag „Angebot von LEBENSART“.
- Einstellung `stt_lernreise_url` (Ziel für alle Lernreise-Buttons). Shortcode
  `[stt_lernreise_button text="Zur Lernreise bei LEBENSART"]` gibt den Button mit diesem Ziel
  aus – so muss in Mustern keine URL fest stehen.
- Stufe 2 (später): nächster Jahrgang/Status per LEBENSART-REST.

## 5. SEO – sich gegenseitig stärken

1. **Themen aufteilen.** Transfer: Begleiter*innen finden, Gruppen, Angehörige, Transferabend,
   „Was ist Hypnosystemik“. LEBENSART: Fortbildung/Lernreise, Förderung, Spenden.
   Jede Seite verlinkt für das Thema der anderen *auf* die andere.
2. **Kontextlinks** im Text mit beschreibendem Linktext statt seitenweiter Fußzeilen-Links.
3. **Kein doppelter Inhalt** zwischen den Seiten.
4. **Strukturierte Daten:** Das vorhandene SEO-Plugin (Meta deutet auf Rank Math oder Yoast)
   bleibt zuständig. Das Theme gibt **kein** eigenes JSON-LD aus, außer die Option
   `stt_jsonld_familie` ist aktiv (Standard: aus). Dann: `Organization` mit `@id`,
   `name`, `url`, `logo` und Verweis auf LEBENSART. Beziehungstyp nach Entscheidung D7
   (`parentOrganization` nur, wenn rechtlich zutreffend).
5. **Semantik & Technik:** genau eine H1, Überschriften ohne Sprünge, `lang="de"`,
   sprechende Alt-Texte, responsive Bilder (`wp_get_attachment_image` mit Größen),
   kein jQuery, Schriften vorladen, keine Render-Blocker außer CSS.
6. **Search Console** für beide Seiten (Doku für Tom, kein Code).
