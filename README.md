ATC - Diana & Titan Compiler
============================

*Diana & Titan* (abbr.: AT) is a mix of *C++* & *PHP*, plus some weird ideas.


Weird Ideas
-----------

  - Prefer unique meaning of each operator.
    E.g. in C++

    - `&` can be getting address, or bit and;
    - `*` can be multiplication, or dereference.

    *AT* tries to avoid this.

  - Reduce the need of [name mangling][nm].
    Use @export mark to give an unique name.

  - Prefer less key press, especially less combination key press.

  - Single command to build, no link required.


File Extensions
---------------

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

### Literals

There are 3 type of literals.

  - Single quoted ('), for character.
  - Double quoted ("), for string.
  - Back quoted (`), for no escaping string. E.g.

    <pre>`delimiter`\nothing "is" `changed``delimiter` -> \nothing "is" `changed`</pre>

Literals may have suffix (to be determined).


Key Words
---------

### Definition

  - `call`
  - `class`
  - `scope`
  - `unit`


### Declaration

  - `base`
  - `new` auto in C++


### Jump

  - `break`
  - `rewind`
  - `return`
  - `throw`
  - `veer`


### Block

  - `case`
  - `catch`
  - `default`
  - `each`
  - `else`
  - `if`
  - `loop`
  - `switch`
  - `try`


### Preposition

  - `as`
  - `in`


### Reference

  - `include`
  - `require`


### Value

  - `null`
  - `true`
  - `false`

  - `this`


Macros
------

### Fungible

  - `_call`
  - `_case`
  - `_class`
  - `_scope`


### String

  - `_call_`
  - `_case_`
  - `_class_`
  - `_file_`
  - `_line_`
  - `_loop_`
  - `_scope_`


Build-in Method
---------------

  - `_create`
  - `_delete`
  - `_copy`
  - `_move`


### Iteration

  - `_head`
  - `_tail`
  - `_next`


Operators
---------

  - `+` add
  - `-` subtract
  - `*` multiply
  - `/` divide
  - `%` integer divide with remainder, `1, 2 = 7 % 5`

  - `.` member
  - `:` assign
  - `,` list separator
  - `#` note
  - `@` placement new
  - `\` escaping in literals
  - `$` reference, & in C++


### Comparison

  - `>`; `>=`
  - `<`; `<=`

  - `=` equal; `^=` bitwise equal
  - `!=` not equal; `^!=` bitwise not equal


#### Logicals

  - `!` not; `^!` bitwise not, ~ in C++
  - `&` and; `^&` bitwise and
  - `|` or;  `^|` bitwise or
  - `~` xor; `^~` bitwise xor, ^ in C++


### Bitwise Shift

  - `<<` shift left,  `<<<` rotate left,  `^<<` rotate through carry left
  - `>>` shift right, `>>>` rotate right, `^>>` rotate through carry right


### Combined Assignment

  - `&:`; `^&:`
  - `|:`; `^|:`
  - `~:`; `^~:`
  - `<<:`; `<<<:`; `^<<:`
  - `>>:`; `>>>:`; `^>>:`


### Brackets

  - `( )` call parameters, array indexing, sub expression
  - `[ ]` code block
  - `{ }` template parameters, array


### Prefix

Each instance can only has 1 option from each category.

  - Access prefix. For scope, class, base, call, unit.

    - `(empty)` public
    - `+` protected
    - `-` private

  - Locate prefix. For member call, unit.

    - `.` static, also for local variable
    - `*` virtual, also for base
    - `=` override, not optional as in C++

  - Reference prefix. For unit, local variable.

    - `$` reference

  Must be sorted in (access, locate, reference) order.

  - Call parameter prefix.

    - `(empty)` in, constant reference
    - `$` in & out, reference
    - `-` out, move

    Call parameters must be sorted in (in, in&out, out) order.


### Not Used

  - `?`


Marks in Note
-------------

  - `@accept` suppress compiler notice, e.g. # @accept final
  - `@final`
  - `@peace` noexcept in C++
  - `@align`
  - `@export` can give several names, unavailable for unspecialized template
  - `@rank` class member order for memory layout
  - `@invariant` constexpr in C++
  - `@reflection` generate reflection data


[nm]: http://en.wikipedia.org/wiki/Name_mangling#Name_mangling_in_C.2B.2B
