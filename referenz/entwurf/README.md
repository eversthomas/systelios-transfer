# Entwurf (abgestimmt am 29.10.2026)

Drei Seiten aus der Design-Arbeitsfläche, im Format `.dc.html` (HTML mit Inline-Styles und
einer kleinen Laufzeit-Syntax wie `{{hs}}`, `<sc-for>`, `<sc-if>`). **Nicht direkt verwenden.**
Sie zeigen Aufbau, Abstände, Größen und Farben – umgesetzt wird über Tokens und Klassen
(`docs/02-designsystem.md`).

| Datei | Seite |
|---|---|
| `Main.dc.html` | Startseite |
| `Hypnosystemik.dc.html` | Inhaltsseite „Was ist Hypnosystemik“ (Seitenkopf, Sprungleiste, Bänder, Prinzipien, Auf den Punkt) |
| `Begleiter.dc.html` | Verzeichnis mit Filtervorschlag (Gestaltung für BSEasy Sync) |

`{{hs}}` = `italic` (kursive Überschriften, Familienkonstante).

## Abweichungen, die das Theme bewusst anders macht als der Entwurf
- Kopfleiste **68px** statt 84px (Familienkonstante).
- Google Fonts im Entwurf → im Theme **lokale** Schriften.
- Feldrand `#9C8B63` statt `#CDBF9F` (Kontrast).
- Zitat in **Cormorant Garamond** (Familienmerkmal), im Entwurf noch Barlow.
- Logoleiste „Wirkungsfamilie“ im Entwurf → Familienleiste wie LEBENSART + kleine Leiste „verbundene Anbieter“.
- Bilder im Entwurf sind Ausschnitte aus Screenshots → im Theme die Originale aus der Mediathek.
