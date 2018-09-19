import request from '@/utils/request'

/**
 * 获取列表
 */
export function getList(data) {
  return request({
    url: '/articles/get-list',
    method: 'post',
    data: data
  })
}

/**
 * 获取文章内容
 * @param data
 */
export function getData(data) {
  return request({
    url: '/articles/get-data',
    method: 'post',
    data: data
  })
}

/**
 * 添加
 */
export function createData(data) {
  return request({
    url: '/articles/add',
    method: 'post',
    data: data
  })
}

/**
 * 编辑
 */
export function updateData(data) {
  return request({
    url: '/articles/edit',
    method: 'post',
    data: data
  })
}

/**
 * 删除
 */
export function deleteData(data) {
  return request({
    url: '/articles/delete',
    method: 'post',
    data: data
  })
}
