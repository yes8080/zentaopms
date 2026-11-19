"""Build a ZenTao extension ZIP from the files shipped to the installer."""

import argparse
from pathlib import Path
from zipfile import ZIP_DEFLATED, ZipFile


def main():
    parser = argparse.ArgumentParser(description=__doc__)
    parser.add_argument("output", type=Path)
    output = parser.parse_args().output

    root = Path(__file__).resolve().parent
    with ZipFile(output, "w", ZIP_DEFLATED) as archive:
        # ZenTao derives the common extraction prefix from the first entry.
        archive.writestr(f"{root.name}/", "")
        for directory in ("db", "doc", "extension"):
            for path in sorted((root / directory).rglob("*")):
                if path.is_file():
                    archive.write(path, Path(root.name) / path.relative_to(root))


if __name__ == "__main__":
    main()
