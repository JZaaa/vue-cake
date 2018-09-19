import { serverInfo } from '@/api/common'

const common = {
  state: {
    serverInfo: []
  },
  mutations: {
    SET_SERVER_INFO: (state, serverInfo) => {
      state.serverInfo = serverInfo
    }
  },
  actions: {
    GenerateServerInfo({ commit }) {
      return new Promise((resolve, reject) => {
        serverInfo().then(response => {
          commit('SET_SERVER_INFO', response)
          resolve()
        }).catch(error => {
          reject(error)
        })
      })
    }
  }
}

export default common
