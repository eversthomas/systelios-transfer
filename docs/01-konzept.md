# 01 – Konzept

## Ausgangslage

- systelios-transfer.de läuft auf WordPress mit **Elementor (Pro)**. Design „ok, eher
  durchschnittlich“; Pflege hängt am Page-Builder.
- Juli 2026: **Sicherheitsvorfall** (wp2shell-Webshell). Bereinigt; WP File Manager entfernt.
  Konsequenz für das neue Theme: so wenig Angriffsfläche wie möglich, keine Builder-Abhängigkeit.
- Die Partnerseite **sysTelios LEBENSART** bekommt ein eigenes Theme (Referenz in
  `referenz/lebensart/`). Beide Seiten gehören zur **sysTelios-Wirkungsfamilie** und sollen
  als verwandt erkennbar sein.
- Begleiter*innen-Verzeichnis und Angebote/Termine kommen aus easyVerein über das
  eigene Plugin **BSEasy Sync** (Shortcodes). Das Plugin bringt eigene, anpassbare Styles mit.

## Ziel

Ein schlankes, eigenes **klassisches Theme**, das

1. die Seite ruhiger, klarer und markentreuer macht (Weiterentwicklung, keine Neuerfindung),
2. von **2–3 Redakteur*innen** ohne Technikwissen sicher gepflegt werden kann,
3. beim Umstieg **sofort vollständig** aussieht (Fallback-Inhalte), und
4. die Familie mit LEBENSART sichtbar macht und beide Seiten gegenseitig stärkt
   (Hinweise, Newsletter-Hinweis, Lernreise, Familienmodul, SEO).

## Rollenverteilung

| Ebene | Zuständig | Beispiele |
|---|---|---|
| **Rahmen** | Theme (fest, nicht editierbar) | Kopfleiste, Menü, Seitenkopf, Fußzeile, Familienleiste, Newsletter-Hinweis |
| **Inhalt** | Redakteur*innen im Block-Editor | Texte, Bilder, Abschnitte aus Mustern |
| **Daten** | BSEasy Sync (Shortcodes) | Begleiter*innen, Termine Transferabend, ggf. weitere Angebote |
| **Einstellungen** | Admin (Tom) | Newsletter-Ziel, Lernreise-Link, Familienliste, Kontaktadresse |

## Seitenbestand (Stand 10/2026)

| Seite | Slug (vermutet, per Export prüfen) | Besonderheit |
|---|---|---|
| Startseite | (statische Startseite) | festes Gesamtmuster, nur Inhalt editierbar |
| Angebote | `unsere-angebote` | Übersicht der drei Angebote |
| ↳ Transferabend online | `transferabend-online` | Terminliste per Shortcode (BSEasy Sync / easyVerein) |
| ↳ Gruppen vor Ort | `gruppen-vor-ort` | Liste nach PLZ-Bereichen, Links auf PDFs/Seiten – **von Hand gepflegt** |
| ↳ Für Angehörige | `angehoerige` | Liste nach PLZ-Bereichen + Online, Links (u. a. Google Forms) |
| ↳ **Lernreise** (neu) | `lernreise` | eigener Text aus Transfer-Sicht, Buchung bei LEBENSART |
| Therapeuten und Coaches | `therapeuten-und-coaches` | Einleitung, Netzwerkkriterien, Haftungshinweis, dann Verzeichnis-Shortcode |
| Was ist Hypnosystemik | `was-ist-hypnosystemik` | langer Fachtext, Sprungmarken |
| Kontaktaufnahme | `kontaktaufnahme` | Kontaktformular (bisher Elementor) – Ersatz siehe D3 |
| Impressum, Datenschutzerklärung | `impressum`, `datenschutzerklaerung` | reiner Text |

## Was das Theme bewusst nicht tut

- Kein eigener Seitenbaukasten, keine frei wählbaren Farben/Schriftgrößen im Editor.
- Keine Datenhaltung für Begleiter*innen oder Termine (macht das Plugin).
- Keine Newsletter-Anmeldung auf Transfer (nur Hinweis + Link zu LEBENSART).
- Keine Buchung der Lernreise (Link zu LEBENSART).
- Kein Dark-Mode-Umschalter (Dark Mode folgt dem System, Phase 6, optional).

## Technischer Rahmen

- WordPress **≥ 6.6** (theme.json v3), PHP **≥ 8.1**
- Klassisches Theme mit `theme.json` (nur Einstellungen/Presets), Mustern in `patterns/`,
  Block-Stilen per `register_block_style()`
- Abhängigkeiten: keine. Optional erkannt: BSEasy Sync, SEO-Plugin (Rank Math/Yoast – nicht doppeln)
