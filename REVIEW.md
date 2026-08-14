# Review instructions

A verification stand. Only `src/` matters.

Report **only** findings that let one customer read or change another
customer's data. Anything a customer can do to their own data is out of scope
here, however wrong it looks: pagination arithmetic, off-by-one boundaries,
rounding and formatting are all deliberately left alone in this repository.

Do not report:
- anything under `legacy/`, which is dead and awaiting deletion
- missing tests, formatting or naming
