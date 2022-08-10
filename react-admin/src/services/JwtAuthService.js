import fetch from 'auth/FetchInterceptor'

const JwtAuthService = {}

JwtAuthService.login = function (data) {
	return fetch({
		url: '/login',
		method: 'post',
		headers: {
			'public-request': 'true'
		},
			data: data
		})
}

// JwtAuthService.signUp = function (data) {
// 	return fetch({
// 		url: '/auth/signup',
// 		method: 'post',
// 		headers: {
//       'public-request': 'true'
//     },
// 		data: data
// 	})
// }

export default JwtAuthService