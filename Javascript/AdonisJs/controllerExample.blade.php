

    Route.get('/name', ({response}) => {
        return response.send("my name is john doe")
    })

    Route.get('/name/:id', ({response,params}) => {
    return response.send("my name is " + params.id)
    })

    Route.get('/test', 'TestController.index')

    Route.get('/login', 'AuthController.login').as('login') // name route