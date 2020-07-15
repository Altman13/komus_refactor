import { UserFactory } from './UserFactory'

let factory = new UserFactory()
let user_group = JSON.parse(localStorage.getItem( 'user_group' ) || '{}' )
let user = factory.getUserRole(parseInt( user_group ))
let user_type
    switch (user!.constructor.name) {
        case 'Operator':
            user_type = 'Operator'
            break
        case 'St_operator':
            user_type = 'St_operator'
            break
        case 'Administrator':
            user_type = 'Administrator'
            break
        default:
            break
    }
export default user_type
    