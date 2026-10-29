# 04 – Bestehende Inhalte als veränderbarer Fallback

**Ziel:** Nach dem Theme-Wechsel ist jede bekannte Seite sofort vollständig und im neuen
Design sichtbar, ohne dass vorher jemand Inhalte nachbauen muss. Später übernimmt man jede
Seite per Knopf in den Block-Editor und pflegt sie von da an normal. Alles bleibt umkehrbar.

Ausgenommen sind Begleiter*innen und Angebote/Termine: Die kommen weiter per Shortcode
aus BSEasy Sync. Die Fallback-Muster enthalten genau diese Shortcodes an der richtigen Stelle.

## 1. Ablauf in drei Schritten

```
[Export]                 [Fallback-Muster]                 [Übernehmen]
tools/export-inhalte.php → patterns/inhalt-<slug>.php  →  Knopf „In den Editor übernehmen“
(einmalig, lokal)          (Cursor baut sie, Skill          schreibt das Muster in den
                            inhalt-zu-muster)                Seiteninhalt (mit Revision)
```

## 2. Zustände einer Seite

Meta `_stt_inhalt` (leer | `eigen` | `fallback`):

| Zustand | Bedingung | Was das Frontend zeigt |
|---|---|---|
| **Fallback automatisch** | `_stt_inhalt` leer **und** (Seite ist Elementor-Seite `_elementor_edit_mode = builder` **oder** `post_content` ist leer) **und** es gibt ein Fallback-Muster | das Muster |
| **Fallback erzwungen** | `_stt_inhalt = fallback` und Muster existiert | das Muster (zum Testen/Zurückstellen) |
| **Eigener Inhalt** | `_stt_inhalt = eigen` | `the_content()` normal |
| **Ohne Fallback** | kein Muster vorhanden | `the_content()` normal; bei Elementor-Seiten Admin-Warnung |

Elementor-Meta wird **nie** verändert oder gelöscht. Das Theme geht davon aus, dass
Elementor deaktiviert ist; ist es aktiv, erscheint ein Admin-Hinweis.

## 3. Zuordnung Seite → Muster

`inc/config.php`, Funktion `stt_fallback_karte()`, gibt ein Array zurück:

```php
return array(
	'__startseite'            => array( 'muster' => 'stt/startseite' ),
	'unsere-angebote'         => array( 'muster' => 'stt/inhalt-angebote', 'lead' => '…', 'bild' => 0 ),
	'transferabend-online'    => array( 'muster' => 'stt/inhalt-transferabend-online', 'lead' => '…' ),
	// … weitere aus inhalte/index.json
);
```

- Schlüssel = `post_name` der Seite; `__startseite` = die Seite aus `page_on_front`.
- `lead`: Einleitung für den Seitenkopf, solange der Textauszug leer ist.
- `bild`: Anhang-ID für das Bildband, solange kein Beitragsbild gesetzt ist (0 = keins).
- Die Slugs stammen aus dem Export (`inhalte/index.json`), nicht aus Vermutungen.

## 4. Seitenkopf im Fallback

Titel kommt immer aus WordPress. Einleitung: Textauszug, sonst `lead` aus der Karte.
Bildband: Beitragsbild, sonst `bild` aus der Karte. So stimmt der Seitenkopf schon vor
der Übernahme.

## 5. „Übernehmen“ – die Admin-Seite

Menü **Design → Transfer-Inhalte** (Capability `edit_pages`). Tabelle:

| Seite | Zustand | Aktionen |
|---|---|---|
| Was ist Hypnosystemik | Fallback automatisch | **In den Editor übernehmen** · Vorschau |
| Kontaktaufnahme | Eigener Inhalt (übernommen am …) | **Auf Fallback zurückstellen** |
| Impressum | Ohne Fallback | – |

**In den Editor übernehmen** (`admin-post.php`, Nonce, `current_user_can('edit_page', $id)`):
1. Rohinhalt des Musters holen (`WP_Block_Patterns_Registry::get_instance()->get_registered()`).
2. `wp_update_post()` mit `post_content` = Muster-Inhalt. WordPress legt dabei eine Revision an.
3. Textauszug leer → `lead` setzen. Kein Beitragsbild → `bild` setzen, falls > 0.
4. `_stt_inhalt = eigen`, `_stt_uebernommen = current_time('mysql')`.
5. Zurück zur Liste mit Erfolgsmeldung und Link „Im Editor öffnen“.

**Alle übernehmen**: dieselbe Aktion für alle Seiten im Zustand „Fallback automatisch“,
mit Bestätigungsschritt (eigene Bestätigungsseite, kein JS-`confirm()`).

**Auf Fallback zurückstellen**: setzt `_stt_inhalt = fallback`. Der Inhalt bleibt in der
Datenbank, über Revisionen ist jeder Stand wiederherstellbar.

## 6. Hinweis im Editor

Öffnet jemand eine Seite im Zustand „Fallback automatisch“, zeigt der Block-Editor oben
einen Hinweis (kleines Skript `assets/js/editor-hinweis.js`, `wp.data.dispatch('core/notices')`):

> Diese Seite zeigt auf der Website derzeit den mitgelieferten Inhalt des Themes.
> Damit Sie ihn bearbeiten können, übernehmen Sie ihn zuerst. **[Inhalt übernehmen]**

Der Knopf führt zur Übernahme-Aktion für genau diese Seite.

## 7. Regeln für Fallback-Muster (Kurzfassung – ausführlich im Skill `inhalt-zu-muster`)

- **Wortlaut übernehmen**, nicht umformulieren. Auffälligkeiten (Tippfehler, veraltete Termine,
  kaputte Links) nur in `inhalte/AUFFAELLIGKEITEN.md` notieren.
- Die H1 der alten Seite entfällt (kommt aus dem Titel). Inhalt beginnt mit H2.
- Fett gesetzte Pseudo-Überschriften („PLZ-Bereich 3“) werden echte H2/H3 mit Anker.
- Wiederkehrende Elemente der alten Seiten entfallen im Muster, weil Theme oder
  synchronisierte Muster sie liefern: Logoleiste der Partner, „Ins Gespräch kommen“-Block,
  „Nach oben scrollen“, doppelte Menüs.
- **Interne Links** mit `home_url()` erzeugen, **Bilder** über die Anhang-ID
  (`wp_get_attachment_image_url()`), damit die Muster lokal und live funktionieren.
  Fehlt ein Anhang, wird das Bild weggelassen.
- **Shortcodes** exakt so übernehmen, wie der Export sie meldet, in einem `core/shortcode`-Block.
- Nur Blöcke aus der Erlaubt-Liste und Block-Stile aus Doku 03 verwenden.
- Kontaktformular: nicht nachbauen. Platzhalter-Shortcode laut Entscheidung D3.
