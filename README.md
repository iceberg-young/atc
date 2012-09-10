ATC - Diana & Titan Compiler
============================

*Diana & Titan* (abbr.: AT) is a mix of *C++* & *PHP*, plus some weird ideas.


Weird Ideas
-----------

  - Prefer unique meaning of each operator.
    E.g. in C++

    - `&` can get address, or bit and;
    - `*` can multiply, or dereference.

    *AT* tries to avoid this.

  - Reduce the need of [name mangling][nm].

    - Overloading.
      Programmer should be able to specify distinct name to each overloading.
      I.e. write distinct functions first, then put them into an alias group.

      ```
      alias glColor : {glColor3ub, glColor4f}; # Refer OpenGL functions
      ```

    - Template specialization.

      ```
      alias template_class{specialized_arguments} : specialized_class;
      ```

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

  - `alias`
  - `base`
  - `new`


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

  - Access prefix. For scope, class, base, call, unit.

    - `+` protected
    - `-` private

  - Locate prefix. For member call.

    - `.` static, also for unit and local variable
    - `*` virtual, also for base
    - `=` override, not optional as in C++

  Access prefix must before locate prefix.

  - Function parameter prefix.

    - `+` in & out
    - `-` out


### Not Used

  - `?`
  - `$`


Marks in Note
-------------

  - `@accept` suppress compiler notice, e.g. # @accept final
  - `@final`
  - `@peace` noexcept in C++


[nm]: http://en.wikipedia.org/wiki/Name_mangling#Name_mangling_in_C.2B.2B
