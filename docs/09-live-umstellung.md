# 09 – Live-Umstellung

Checkliste für den Wechsel von Elementor auf das Theme **sysTelios Transfer**. Alles ist umkehrbar:
Elementor-Daten bleiben unangetastet, und das alte Theme lässt sich jederzeit wieder aktivieren.

## 0. Vorher (einmalig)

- [ ] Die offenen Entscheidungen in `docs/08-entscheidungen.md` durchgehen. Besonders wichtig:
  - **D2** Shortcodes aus BSEasy Sync prüfen, vor allem die Kalender-ID (`inc/config.php`, `stt_shortcodes()`).
  - **D6** Familiendaten (Namen, Reihenfolge, Farben) aus dem LEBENSART-Plugin eintragen (Transfer-Einstellungen).
  - **D8** SVG-Logo liefern (bis dahin PNG, nur 370 px breit).
  - **D11** Texte der Lernreise-Seite schreiben.
- [ ] Pakete bauen: `bash tools/paket.sh` → `dist/systelios-transfer-<Version>.zip` und `dist/stt-kontakt-<Version>.zip`.
- [ ] Die Pakete einmal auf einer **Kopie** der Live-Seite (Staging) durchspielen. Nur eine Kopie aus dem bereinigten Zustand nach dem Sicherheitsvorfall (07/2026) verwenden.

## 1. Sicherung

- [ ] Vollständiges Backup: Datenbank **und** `wp-content/uploads`, dazu das aktive Theme und die Plugins.
- [ ] Prüfen, dass sich das Backup wiederherstellen lässt (Stichprobe auf der Kopie).
- [ ] Einen Zeitpunkt wählen, an dem wenig los ist, und kurz Bescheid sagen.

## 2. Sicherheit festziehen (empfohlen)

In der `wp-config.php` (nicht im Theme):

```php
define( 'DISALLOW_FILE_EDIT', true );   // keine Datei-Editoren im Backend
// optional: define( 'WP_POST_REVISIONS', 20 );
```

- [ ] WordPress, Plugins und PHP auf aktuellem Stand.
- [ ] Nur Redakteur*innen-Rolle für die zwei bis drei Pflegenden, Administrator nur für dich.
- [ ] Das Plugin **WP File Manager** bleibt entfernt.

## 3. Theme und Plugin hochladen

- [ ] Backend → Design → Themes → Installieren → **Theme hochladen** → `systelios-transfer-<Version>.zip`. **Noch nicht aktivieren.**
- [ ] Backend → Plugins → Installieren → **Plugin hochladen** → `stt-kontakt-<Version>.zip` (Kontaktformular). **Aktivieren.**

## 4. Elementor deaktivieren (nicht löschen)

- [ ] Plugins → Elementor und Elementor Pro **deaktivieren**. Nicht löschen: Die Daten (`_elementor_*`) bleiben erhalten, damit du zurückkehren kannst.
- [ ] Hinweis: Das Theme geht davon aus, dass Elementor deaktiviert ist. Solange es aktiv ist, zeigt Design → Transfer-Inhalte eine Warnung.

## 5. Theme aktivieren

- [ ] Design → Themes → **sysTelios Transfer aktivieren**.
- [ ] Die synchronisierten Muster („Kontaktfläche“, „Hinweis Heilkunde“) werden dabei angelegt. Sonst: Design → Transfer-Inhalte → „Fehlende Muster anlegen“.
- [ ] Design → Menüs: Hauptmenü der Position **Hauptmenü** zuweisen, ein Fußmenü (Kontakt, Impressum, Datenschutz) der Position **Fußmenü**. „Lernreise“ als Unterpunkt von „Angebote“ ergänzen (D12).

## 6. Einstellungen

Design → **Transfer-Einstellungen**:

- [ ] Newsletter-Adresse (Anmeldung bei LEBENSART) eintragen, sonst erscheint kein Newsletter-Hinweis.
- [ ] Lernreise-Adresse eintragen.
- [ ] Kontakt-E-Mail eintragen (Empfänger des Formulars).
- [ ] Wirkungsfamilie prüfen (Namen, Reihenfolge, Farben, Adressen).
- [ ] JSON-LD nur einschalten, wenn kein SEO-Plugin strukturierte Daten liefert.

## 7. Seiten prüfen

Alle Seiten im Frontend ansehen (Desktop und Handy), mit Blick auf:

- [ ] Startseite, Angebote, Transferabend online, Gruppen vor Ort, Für Angehörige, Therapeuten und Coaches, Was ist Hypnosystemik, Kontaktaufnahme, Impressum, Datenschutzerklärung, Lernreise.
- [ ] Verzeichnis und Termine erscheinen an der richtigen Stelle.
- [ ] Bilder und PDF-Links funktionieren (Mediathek).
- [ ] Impressum und Datenschutzerklärung: **kein** Fallback (D9). Prüfen, dass der bisherige Text noch da ist.
- [ ] Kontaktformular: Test-Nachricht senden, E-Mail kommt an.
- [ ] Seiten ohne mitgelieferten Inhalt, die früher Elementor waren, erscheinen leer: Design → Transfer-Inhalte zeigt sie als „Ohne Fallback“. Entweder Inhalt neu anlegen oder zurück auf das alte Theme.

## 8. Inhalte übernehmen (nach Bedarf)

- [ ] Design → **Transfer-Inhalte**: Seiten, die du im Block-Editor pflegen willst, mit „In den Editor übernehmen“ übernehmen (oder „Alle übernehmen“).
- [ ] Danach lässt sich jede Seite wie gewohnt bearbeiten; der frühere Stand bleibt als Revision erhalten. Mit „Auf Fallback zurückstellen“ geht es zurück.

## 9. Suchmaschinen

- [ ] Search Console für **beide** Seiten (TRANSFER und LEBENSART) einrichten bzw. prüfen.
- [ ] Sitemap prüfen und Weiterleitungen, falls sich Adressen geändert haben.
- [ ] Kontextlinks zwischen den Seiten sind gesetzt (Familienhinweise, Lernreise). Themen der beiden Seiten nicht doppeln.

## 10. Rückweg (falls etwas Gravierendes schiefgeht)

1. Design → Themes → das **alte Theme** wieder aktivieren.
2. Elementor und Elementor Pro wieder aktivieren. Die Seiten sehen aus wie vorher, weil die Daten nie angetastet wurden.
3. Bei Bedarf Backup einspielen.

## 11. Aufräumen (nach vier Wochen)

Wenn alles stabil läuft:

- [ ] Elementor und Elementor Pro **löschen** und das alte Theme entfernen.
- [ ] Nicht mehr benötigte Revisionen und Entwürfe aufräumen.
- [ ] Offene Entscheidungen in `docs/08-entscheidungen.md` auf „gesetzt“ stellen.

## Anhang: Was im Paket steckt

Das Theme-ZIP enthält nur die ausgelieferten Dateien (`style.css`, `functions.php`, Vorlagen, `inc/`, `patterns/`, `template-parts/`, `assets/`, `theme.json`, `screenshot.png`).
**Nicht** enthalten sind die Entwicklungsordner `docs/`, `referenz/`, `tools/`, `inhalte/`, `_plugins/`, `.cursor/` sowie `AGENTS.md` und `README.md`.
