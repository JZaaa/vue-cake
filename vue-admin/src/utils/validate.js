/**
 * Created by jiachenpan on 16/11/18.
 */

export function isvalidUsername(str) {
  const valid_map = ['admin', 'editor']
  return valid_map.indexOf(str.trim()) >= 0
}

/* 合法uri*/
export function validateURL(textval) {
  const urlregex = /^(https?|ftp):\/\/([a-zA-Z0-9.-]+(:[a-zA-Z0-9.&%$-]+)*@)*((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9][0-9]?)(\.(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9]?[0-9])){3}|([a-zA-Z0-9-]+\.)*[a-zA-Z0-9-]+\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(:[0-9]+)*(\/($|[a-zA-Z0-9.,?'\\+&%$#=~_-]+))*$/
  return urlregex.test(textval)
}

/* 小写字母*/
export function validateLowerCase(str) {
  const reg = /^[a-z]+$/
  return reg.test(str)
}

/* 大写字母*/
export function validateUpperCase(str) {
  const reg = /^[A-Z]+$/
  return reg.test(str)
}

/* 大小写字母*/
export function validatAlphabets(str) {
  const reg = /^[A-Za-z]+$/
  return reg.test(str)
}

/* 数字 */
export function validatDigits(number) {
  const reg = /^\d+$/
  return reg.test(number)
}

/* 手机 */
export function validatMobile(number) {
  const reg = /^1[3-9]\d{9}$/
  return reg.test(number)
}

/**
 * 整数
 * @param number
 * @param params
 * params 整数
   params[+] 正整数
   params[+0] 正整数和零
   params[-] 负整数
   params[-0] 负整数和零
 * @returns {boolean}
 */
export function validatInteger(number, params) {
  let reg
  const z = '0|'
  const p = '[1-9]\\d*'
  const key = params ? params[0] : '*'
  switch (key) {
    case '+':
      reg = p
      break
    case '-':
      reg = '-' + p
      break
    case '+0':
      reg = z + p
      break
    case '-0':
      reg = z + '-' + p
      break
    default:
      reg = z + '-?' + p
  }
  reg = '^(?:' + reg + ')$'
  return new RegExp(reg).test(this.value)
}

