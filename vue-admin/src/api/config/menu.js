import request from '@/utils/request'

/**
 * 获取列表,无分页
 */
export function getList(data) {
  return request({
    url: '/menus/get-list',
    method: 'post',
    data: data
  })
}

/**
 * 添加
 */
export function createData(data) {
  return request({
    url: '/menus/add',
    method: 'post',
    data: data
  })
}

/**
 * 编辑
 */
export function updateData(data) {
  return request({
    url: '/menus/edit',
    method: 'post',
    data: data
  })
}

/**
 * 删除
 */
export function deleteData(data) {
  return request({
    url: '/menus/delete',
    method: 'post',
    data: data
  })
}
