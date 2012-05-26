ATC - Diana & Titan Compiler
============================

*Diana & Titan* (abbr.: AT) is a mix of *C++* & *PHP*, plus some weird ideas.


Source File
-----------

There are 2 type of source file.

  - __*.atd__ The definitions of class, function, etc.
    It excludes any auto-executed code. E.g.:

    - Executing sequence which not in a function.
    - Global variables (which have ex|implicit constructors).

    The purpose of excluding auto-executed code is trying to avoid *undefined*
    execution order for *human*.

  - __*.ate__ The body of the `main()` as in C++.
    It excludes any definition code. E.g.:

    - Class, function, and name space, etc.

    The purpose of excluding definition code is trying to avoid declaring order
    dependency.


Data Types
----------

### Literal ###

There are 3 type of literals.

  - Single quoted ('), for character.
  - Double quoted ("), for string.
  - Back quoted (`), for no escaping string. E.g.
    `delimiter`\nothing "is" `changed``delimiter` => \nothing "is" `changed`

Literals can have suffix.

Weird Ideas
-----------

  - Prefer unique meaning of each operator.
    E.g. in C++

    - `&` can be get address, or bit and;
    - `*` can be multiply, or dereference.

    *AT* tries to avoid this.

  - Prefer less key press, especially less combination key press.

  - Single command to build, no link.
