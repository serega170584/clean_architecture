# Architecture description

## Architecture layers and directories

All files of project are in directory ```src```.  Architecture is divided into layers

- Business logic that includes contracts of business logic involving models and interfaces(directory ```Contract```) and implementation of business logic(directory ```Domain```)
    
    - Main directories we can see inside ```Contract``` directory are ```Model``` and ```UseCase```. ```Model``` consists of ```models``` which are container for entities in business logic. ```UseCase``` includes abstractions of logic of operations. This layer is closed in itself and knows nothing about other layers in architecture. So we can reuse and port independent programming code in layer between different environments. For example we can pack contracts into composer package and install it through ```composer install```.
- Next layer implemented previous one. For example we can note implementation of ```factories``` and ```use cases```. This layer knows only about previous one and more nothing. As its contracts it's portable and independant.
- Next level includes abstactions and implementations which use business logic. They recognize each other. In other environments we can use similar abstractions using contracts and implementations of our business logic. It depends on our task. We can also name this layer as ```layer of adapters``` for business logic.

Notice: Example of console application for our business logic we can use through ```php src/console.php```. I would like to note that through ```tools/php-cs-fixer/vendor/bin/php-cs-fixer fix src``` and ```vendor/bin/phpstan analyse src``` we can check and fix our code.

## Patterns 

- ```BalanceCalculationFactoryInterface``` and its implementation ```BalanceCalculationFactory```. We can also name this pattern as ```factory method```. Currently we don't know what calculation algorithm of account balance to be used: increasing(IncreaseBalanceCalculation) or decreasing(DecreaseBalanceCalculation). To define it we need logic that depends on operation type. We encapsulate logic into factory. Factory creates needed algorithm.
- Probably ```BalanceCalculationInterface```  and its implementations ```DecreaseBalanceCalculation``` and ```IncreaseBalanceCalculation``` are examples of ```strategy``` pattern that defines algorithm of balance calculating
- ```RepositoryInterarface``` and its implementations ```AccountRepository```, ```TransactionRepository```. It's like ```Repository``` pattern and encapsulates logic of getting models mapped to suitable source in database. Reposotory such as ```facade``` that gives only needed methods to get for example model or model's list.  
- Probably I can mention ```validator``` pattern. It's offered by ```TransactionValidatorInterface``` and ```TransactionValidator```. It checks data before business logic code execution. Thanks to this pattern we avoid undesirable changes of systems state and implicit. 
- ```UnitOfWorkInterface``` and its implementation ```UnitOfWork```. Probably we can name this pattern as ```command```. It useful when group of operation we need saving as single one. And if there is a trouble in one operation rollback all ones.
- ```Container``` pattern. Now it is easiest pattern that we can develop further. We could be create interface for this implementation and change container depends on environment. This pattern as entry point or configuration of all dependencies in project. Thanks for that pattern we embedded implementation of matched abstraction. So that we use ```inversion of dependencies``` principle.
- ```SerializerInterface``` and its implementations ```DateSerializer```, ```TransactionTypeSerializer```. We can also name this pattern as ```adapter```. It adapts model field value to database entity field value. It transform class field in business logic to string in database.
- ```Model``` in our project is ```entity value```. It's identified by id and has only one instance. 
- Through project we can watch services having only one instance. So we can name its implicit ```singleton```.
- Also there are ```free side effect functions``` that don't change state. 