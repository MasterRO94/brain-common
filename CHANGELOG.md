# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased]
### ADDED

#### Bundle
* Introduced basic `BrainCommonBundle`. 
  Would recommend only using this bundle if you want all the classes to be registered in the container. 
  Otherwise manually register each file in your services configuration.

#### Database
* Added a common entity interface which will be used across the project to denote persistent objects.
* Added a series of pagination classes.
* Added a more advanced repository that can make use of pagination.
* Added the database wrapper which allows the construction of the `AbstractEntityRepository`. 
* Added an abstract factory for helping construct entities.
* Added a query helper for writing raw `SQL` that wouldn't belong in a repository.

#### Enum
* Added a fairly simplistic ENUM implementation.

#### Event
* Added a base event class that has a static method for getting its name.
* Added a base event dispatcher that can dispatch the above events easier.

#### Form & Filter/Sorting
* Added a custom form factory.
* Added a custom form property accessor.
* Added an advanced form handler. 
  This form handler can handle forms that have `PHP@7.0` type hinting.
  It also adds a few defaults to the form options related to API usage.
* Added request filter form handler too implementing Lexik.
  Filters are super advanced so grab a coffee with them.

#### Workflow
* Added an abstract workflow builder.
* Added an abstract workflow guard.

#### Utility
* Added translation wrapper.
* Added a date time factory for creating (soon to be immutable) date time.
* Added a debug stopwatch wrapper that will always be available.
* Added an identity factory, this can be used to create `UUID@4.0`.
  It is better to use this so we can switch factories under the hood. 
