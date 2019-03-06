# Brain Common

**Note** this repository is read-only.

This is the brain common library that contains a series of classes that can be used to "get shit done".
All classes here follow a strict standard and can be used as components on their own or included using the bundle also provided.

# Usage

You can access the classes using their service definitions if you are using the bundle.
When not using the bundle you can construct the classes manually or manually register them in your application.

# Configuration

All configuration is optional!

```YAML
brain_common:
  response:
    factory:
      service: '@custom.response.factory'
```

## Api and Extending

You will notice that almost all classes in this library are concrete (declared `final`) or abstract (declared `abstract`).
Final essentially means that if you want to break the code then you need to wrap it, you will notice that there are a bunch of classes that wrap symfony components.
Abstracts have many final methods to make sure you don't abuse the functionality provided.
Also everything is private so buckle in.

In essence, only extend what is annotated as `@api`.
If something is not annotated as described but is also not declared `final` then you can assume its only safe to override and use parent to change the type hint on the method.
Should you modify the content of a method not annotated as `@api` then make sure you read the `CHANGELOG.md` as you will probably break something when upgrading.

# Form

The form handlers in this library have the ability to mutate data classes that have `PHP@7.0` type hinting.
This is done by implementing its own property accessor and ignoring specific errors when setting/getting data from the data class.

It is recommended that you do not put the constraints against the data class and instead add them in the form.
Make use of the validation groups to enable and disable them.
