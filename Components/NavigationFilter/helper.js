function extractGetParams (param) {
  const query = window.location.search.substring(1)
  const strings = query.split('&')
  if (strings.length === 0 && strings[0].length === false) {
    return {}
  }
  let params = {}
  for (const string of strings) {
    const splitString = string.split('=')
    const key = splitString[0]
    const value = splitString[1]
    params[key] = value
  }
  if (param) {
    return params[param]
  } else {
    return params
  }
}

function buildQueryString (params) {
  let queryStringArray = []
  for (const key in params) {
    const value = params[key]
    if (value && (value + '').length) {
      queryStringArray.push(encodeURIComponent(key) + '=' + encodeURIComponent(value))
    }
  }
  return queryStringArray.join('&')
}

export { extractGetParams }
export { buildQueryString }
