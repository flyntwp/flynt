import test from './foo'

function foo (bar = 'baz') {
  return bar
}

console.log(foo(test), 'exec')

export default {
  foo: 'bar'
}
