---
name: inhalt-zu-muster
description: Wandelt eine exportierte Seite aus inhalte/ in ein Fallback-Muster patterns/inhalt-<slug>.php um und trägt sie in stt_fallback_karte() ein. Verwenden in Phase 4 für jede Seite aus inhalte/index.json.
---

# Inhalt → Fallback-Muster

## Eingaben
- `inhalte/index.json` – Eintrag der Seite (slug, title, excerpt, thumbnail_id, shortcodes, widgets, images)
- `inhalte/<slug>.html` – bereinigtes HTML der alten Seite
- `docs/03-pflegekonzept.md` (Blöcke, Stile, Muster), `docs/04-inhalte-und-fallback.md`

## Schritte

1. **Lesen und gliedern.** Abschnitte der alten Seite bestimmen. Für jeden Abschnitt das
   passende allgemeine Muster wählen (Text mit Bild, Warmes Band, Drei Karten, Prinzipien,
   Auf den Punkt, Zitat, Regionale Übersicht, Sprungleiste). Gibt es keins, schlichte Blöcke.
2. **Entfernen**, was Theme oder synchronisierte Muster liefern:
   - H1 der alten Seite (kommt aus dem Titel)
   - Logoleiste der Partner / Wirkungsfamilie
   - Block „Ins Gespräch kommen“ → stattdessen das synchronisierte Muster einfügen:
     `<!-- wp:block {"ref":<?php echo (int) stt_sync_muster_id( 'kontaktflaeche' ); ?>} /-->`
     (nur ausgeben, wenn die ID > 0 ist)
   - „Nach oben scrollen“, doppelte Menüs, Lesezeit
3. **Überschriften normalisieren.** Inhalt beginnt mit H2. Fett gesetzte Zeilen, die als
   Überschrift dienen (z. B. „PLZ-Bereich 3“), werden H2/H3 mit Anker
   (`{"anchor":"plz-3"}`). Bei mehr als 4 Abschnitten: Muster „Sprungleiste“ oben einsetzen.
4. **Wortlaut** 1:1 übernehmen. Nichts umformulieren, kürzen oder ergänzen.
   Tippfehler, veraltete Termine, kaputte Links → `inhalte/AUFFAELLIGKEITEN.md`
   (Format: `- <slug>: <Fundstelle> – <Beobachtung>`).
5. **Links:** intern mit `home_url( '/<pfad>/' )`, extern unverändert mit `rel="noopener"`.
   PDF-Links als `core/file`-Block, wenn sie als Download gemeint sind, sonst als Textlink.
6. **Bilder:** über `images[].id` aus dem Index. Markup:
   ```php
   <?php $bild = wp_get_attachment_image_url( 123, 'large' ); if ( $bild ) : ?>
   <!-- wp:image {"id":123,"sizeSlug":"large"} -->
   <figure class="wp-block-image size-large"><img src="<?php echo esc_url( $bild ); ?>" alt="<?php echo esc_attr( get_post_meta( 123, '_wp_attachment_image_alt', true ) ); ?>" class="wp-image-123"/></figure>
   <!-- /wp:image -->
   <?php endif; ?>
   ```
7. **Shortcodes** exakt aus `shortcodes[]` übernehmen, an der Stelle, wo die alte Seite sie
   zeigte, als `<!-- wp:shortcode -->[…]<!-- /wp:shortcode -->`. Keine Shortcodes erfinden.
8. **Formulare** (Widget `form`) nicht nachbauen → Platzhalter nach D3 (`[stt_kontakt]`).
9. **Familie:** Wo sinnvoll Muster „Hinweis aus der Familie“ ergänzen (siehe Doku 05 –
   vorgesehene Stellen). Das ist die einzige erlaubte Ergänzung.
10. **Datei schreiben:** `patterns/inhalt-<slug>.php` mit Kopf:
    ```php
    <?php
    /**
     * Title: Fallback – <Seitentitel>
     * Slug: stt/inhalt-<slug>
     * Inserter: no
     * Description: Mitgelieferter Inhalt der Seite „<Seitentitel>“ (Stand Export <Datum>).
     */
    ```
11. **Karte eintragen** in `stt_fallback_karte()`: `muster`, `lead` (aus `excerpt` oder dem
    ersten Einleitungssatz der alten Seite, wörtlich), `bild` (`thumbnail_id` oder ID des
    ersten großen Bildes, sonst 0).
12. **Prüfen:** Seite im Frontend (Fallback) und nach „Übernehmen“ im Editor – keine
    Block-Validierungsfehler, alle Bilder/Links/Shortcodes da.

## Ergebnis melden
Kurz: Datei, verwendete Muster, entfernte Elemente, Einträge in AUFFAELLIGKEITEN.md.
