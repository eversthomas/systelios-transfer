# 08 – Entscheidungen

Cursor arbeitet mit der **Voreinstellung** weiter und markiert betroffene Stellen mit
`// ENTSCHEIDUNG D<n>:`. Tom trägt Änderungen hier ein.

| Nr | Frage | Voreinstellung | Status |
|---|---|---|---|
| D1 | Theme-Name / Slug | „sysTelios Transfer“ / `systelios-transfer`, Präfix `stt_` | gesetzt |
| D2 | Shortcodes von BSEasy Sync (Verzeichnis, Termine, ggf. weitere) | aus `inhalte/index.json` (Feld `shortcodes`) übernehmen; zentral in `stt_shortcodes()` | **Tom prüfen** |
| D3 | Ersatz für das Elementor-Kontaktformular | kleines eigenes Plugin `stt-kontakt` (separat vom Theme, Ordner `_plugins/stt-kontakt/`): Shortcode `[stt_kontakt]`, Felder wie bisher (Vorname*, Nachname*, E-Mail*, Telefon, Nachricht*, Datenschutzhinweis), Nonce, Honeypot, Mindest-Ausfüllzeit, Ratenbegrenzung per Transient (IP-Hash), `wp_mail()` an Einstellung, **keine Speicherung**. Alternative: etabliertes Formular-Plugin | umgesetzt in `_plugins/stt-kontakt/` (Stand Phase 5) |
| D4 | Dark Mode | ja, folgt Systemeinstellung, Phase 6; nur wenn alle Kontraste bestehen | umgesetzt (`assets/css/dunkel.css`, Kontraste geprüft) |
| D5 | Suchleiste Startseite → Verzeichnis mit Filtern | nur wenn das Plugin URL-Parameter für Filter versteht (`stt_shortcodes()['verzeichnis_parameter']`); sonst einfacher Button „Zum Verzeichnis“ | **Tom prüfen** |
| D6 | Familiendaten (Namen, Reihenfolge, Farben, Links) | aus LEBENSART-Must-Use-Plugin übernehmen; bis dahin Platzhalter | **Tom liefert** |
| D7 | Beziehung im JSON-LD | Option standardmäßig aus; falls an: neutraler Verweis, `parentOrganization` nur bei rechtlicher Zugehörigkeit | offen |
| D8 | Logo | SVG-Fassung des Transfer-Logos; bis dahin PNG aus `referenz/bilder/` (nur 370 px breit) | **Tom liefert** |
| D9 | Impressum & Datenschutz | Fallback-Muster mit dem **Ist-Zustand** der Live-Seite (Stand 29.10.2026, Wortlaut unverändert). Rechtlich verbindlich: vor der Live-Schaltung mit der Live-Seite abgleichen, nach dem Übernehmen von der Geschäftsführung/Datenschutz prüfen lassen | gesetzt (geändert am 29.10.2026) |
| D10 | Kursive Überschriften | ja (Familienkonstante) | gesetzt |
| D11 | Texte der Lernreise-Seite | Platzhalter in eckigen Klammern; Tom/Team schreibt | offen |
| D12 | Menüstruktur | bestehende WordPress-Menüs weiterverwenden; „Lernreise“ als Unterpunkt von Angebote ergänzen | gesetzt |
| D13 | Beiträge/Blog | nicht im Fokus; `index.php` schlichte Liste im Theme-Stil | gesetzt |

## Randbefund
Im Verzeichnis steht bei mindestens einem Profil „Array“ statt eines Wertes – vermutlich
ein Ausgabefehler in BSEasy Sync bei einem Mehrfachfeld. Nicht Teil des Themes, aber
beim Testen von Phase 5 im Blick behalten.
