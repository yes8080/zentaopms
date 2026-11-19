"""Build a ZenTao extension ZIP from the files shipped to the installer."""

import argparse
import hashlib
from pathlib import Path
from zipfile import ZIP_DEFLATED, ZipFile, ZipInfo


def main():
    parser = argparse.ArgumentParser(description=__doc__)
    parser.add_argument("output", type=Path)
    parser.add_argument("--sha256", action="store_true", help="Write a checksum beside the ZIP")
    args = parser.parse_args()
    output = args.output

    root = Path(__file__).resolve().parent
    with ZipFile(output, "w", ZIP_DEFLATED) as archive:
        # ZenTao derives the common extraction prefix from the first entry.
        entry = ZipInfo(f"{root.name}/")
        entry.create_system = 3
        entry.external_attr = (0o40755 << 16) | 0x10
        archive.writestr(entry, b"")
        for directory in ("db", "doc", "extension"):
            for path in sorted((root / directory).rglob("*")):
                if path.is_file():
                    name = (Path(root.name) / path.relative_to(root)).as_posix()
                    entry = ZipInfo(name)
                    entry.create_system = 3
                    entry.external_attr = 0o100644 << 16
                    archive.writestr(entry, path.read_bytes(), compress_type=ZIP_DEFLATED)

    if args.sha256:
        checksum = hashlib.sha256(output.read_bytes()).hexdigest()
        output.with_suffix(output.suffix + ".sha256").write_text(
            f"{checksum}  {output.name}\n", encoding="utf-8"
        )


if __name__ == "__main__":
    main()
