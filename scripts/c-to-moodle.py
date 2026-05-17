#!/usr/bin/env python3
"""
Convert C exercise definitions (JSON) to Moodle XML format
for import into the CodeRunner question bank.

Usage:
    ./scripts/c-to-moodle.py exercises/c-examples.json
    ./scripts/c-to-moodle.py exercises/c-examples.json -o c-bank.xml
"""

import argparse
import json
import sys
from pathlib import Path


def c(s):
    return f"<![CDATA[{s}]]>"


def txt(value):
    return f"<text>{c(value)}</text>"


def wtag(name, value, attrs=""):
    a = f" {attrs}" if attrs else ""
    return f"<{name}{a}>{txt(value)}</{name}>"


def build_testcase(test, index):
    attrs = (
        f'type="0"'
        f' useasexample="{1 if test.get("example", False) else 0}"'
        f' hiderestiffail="{1 if test.get("hide_rest_on_fail", False) else 0}"'
        f' mark="{test.get("mark", 1.0)}"'
    )
    fields = ["testcode", "stdin", "expected", "extra", "displayfeedback"]
    children = "\n".join(f"    {wtag(f, test.get(f, ''))}" for f in fields)
    return f'  <testcase {attrs}>\n{children}\n  </testcase>'


def build_question(ex):
    name = ex.get("name", "Unnamed Exercise")
    question_text = ex.get("question", "").strip()
    category = ex.get("category", "$course$/Default")
    template = ex.get("template", "")
    feedback = ex.get("feedback", "")
    all_or_nothing = "1" if ex.get("all_or_nothing", False) else "0"
    grade = ex.get("default_grade", 100)
    penalty = ex.get("penalty", 0)
    templatetype = ex.get("templatetype", "Isotopp")
    tests = ex.get("tests", [])

    testcases_xml = "\n".join(build_testcase(t, i) for i, t in enumerate(tests))

    return f'''  <question type="coderunner">
    {wtag("name", name)}
    {wtag("questiontext", question_text, attrs='format="html"')}
    {wtag("generalfeedback", feedback, attrs='format="html"')}
    {txt(category)}
    <defaultgrade>{grade}</defaultgrade>
    <penalty>{penalty}</penalty>
    <hidden>0</hidden>
    <coderunnertype>c_program</coderunnertype>
    <prototypetype>2</prototypetype>
    <allornothing>{all_or_nothing}</allornothing>
    <template>{c(template)}</template>
    <templatetype>{templatetype}</templatetype>
    <testcases>
{testcases_xml}
    </testcases>
  </question>'''


def main():
    parser = argparse.ArgumentParser(description="C exercises → Moodle XML (CodeRunner)")
    parser.add_argument("input", type=str, help="JSON exercise file")
    parser.add_argument("-o", "--output", type=str, default="moodle-c-questions.xml",
                        help="Output path (default: moodle-c-questions.xml)")
    args = parser.parse_args()

    input_path = Path(args.input)
    if not input_path.exists():
        print(f"Error: file not found: {input_path}", file=sys.stderr)
        sys.exit(1)

    with open(input_path) as f:
        data = json.load(f)

    if not data:
        print("No exercises found.")
        sys.exit(0)

    exercises = data if isinstance(data, list) else [data]

    questions = "\n".join(build_question(ex) for ex in exercises)

    xml = f'<?xml version="1.0" encoding="UTF-8"?>\n<quiz>\n{questions}\n</quiz>\n'

    output_path = Path(args.output)
    output_path.write_text(xml, encoding="utf-8")
    print(f"✓ {len(exercises)} C question(s) → {output_path}")


if __name__ == "__main__":
    main()
