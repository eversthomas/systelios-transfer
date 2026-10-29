#!/usr/bin/env bash
# Baut die Auslieferungspakete in dist/:
#   systelios-transfer-<Version>.zip       das Theme ohne Entwicklungsordner
#   stt-kontakt-<Version>.zip              das Kontaktformular-Plugin
# Aufruf im Theme-Ordner:  bash tools/paket.sh
set -euo pipefail

cd "$(dirname "$0")/.."
THEME_DIR="$(pwd)"
VERSION="$(grep -m1 '^Version:' style.css | sed 's/Version:[[:space:]]*//' | tr -d '\r')"
[ -n "$VERSION" ] || { echo "Version in style.css nicht gefunden" >&2; exit 1; }

echo "== Prüfung =="
# 1. Syntax aller PHP-Dateien
fehler=0
while IFS= read -r -d '' datei; do
  php -l "$datei" >/dev/null || { echo "PHP-Fehler: $datei" >&2; fehler=1; }
done < <(find . -name '*.php' -not -path './.git/*' -not -path './dist/*' -print0)
[ "$fehler" -eq 0 ] || exit 1

# 2. Ausgelieferter Code darf Entwicklungsordner nicht laden (Kommentare mit Verweisen sind erlaubt)
if grep -rnE "(require|include)(_once)?[^;]*(docs|referenz|inhalte|tools|_plugins)/|(STT_DIR|STT_URI|get_template_directory(_uri)?\(\))[^;]*(docs|referenz|inhalte|tools|_plugins)/|url\([^)]*(docs|referenz|inhalte|tools|_plugins)/" \
     assets inc patterns template-parts *.php 2>/dev/null; then
  echo "Achtung: Code lädt Entwicklungsordner (siehe oben)." >&2
  exit 1
fi
# 3. Keine externen Schriften/CDNs
if grep -rnE "fonts\.(googleapis|gstatic)\.com|cdnjs|jsdelivr|unpkg" assets inc patterns template-parts *.php 2>/dev/null; then
  echo "Achtung: externe Ressourcen gefunden." >&2
  exit 1
fi
echo "ok"

mkdir -p dist
rm -f "dist/systelios-transfer-$VERSION.zip" "dist/stt-kontakt-$VERSION.zip"

# Theme: Ordner im ZIP heißt systelios-transfer
echo "== Theme-Paket =="
zip -rq "dist/systelios-transfer-$VERSION.zip" . \
  --include "./*" \
  -x ".git/*" ".cursor/*" "docs/*" "referenz/*" "tools/*" "inhalte/*" "_plugins/*" "dist/*" \
     "AGENTS.md" "README.md" ".gitignore" ".DS_Store" "*/.DS_Store" "*.zip"
# Ordnername im ZIP anpassen (WordPress erwartet einen Ordner im ZIP)
tmp="$(mktemp -d)"
mkdir "$tmp/systelios-transfer"
unzip -q "dist/systelios-transfer-$VERSION.zip" -d "$tmp/systelios-transfer"
rm "dist/systelios-transfer-$VERSION.zip"
( cd "$tmp" && zip -rq "$THEME_DIR/dist/systelios-transfer-$VERSION.zip" systelios-transfer )
rm -rf "$tmp"

# Plugin
echo "== Plugin-Paket =="
tmp="$(mktemp -d)"
cp -R _plugins/stt-kontakt "$tmp/stt-kontakt"
find "$tmp" -name '.DS_Store' -delete
( cd "$tmp" && zip -rq "$THEME_DIR/dist/stt-kontakt-$VERSION.zip" stt-kontakt )
rm -rf "$tmp"

echo "== Inhalt Theme-ZIP (oberste Ebene) =="
unzip -Z1 "dist/systelios-transfer-$VERSION.zip" | cut -d/ -f2 | sort -u | sed '/^$/d'
echo
ls -lh dist/
