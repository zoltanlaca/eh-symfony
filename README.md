# Error Handler

## Setup

### Add Environment Variables

- `EH_ERROR_HANDLER_URL` - URL to the error handler. Eg: `https://localhost/error/handler`
- `EH_ERROR_HANDLER_API_AUTH` - Key to access the error handler API. Eg: `1234567890`


### Add ExceptionListener

Into `config/services.yaml` add the following:

```yaml
services:
  Zoltanlaca\EhSymfony\EventListener\ExceptionListener:
    tags: [ kernel.event_listener ]
```

### Skip exceptions

- copy `Zoltanlaca\EhSymfony\EventListener\ExceptionListener`
- fill `skipExceptions` array with your exceptions
- replace ExceptionListener in config/services.yaml with your ExceptionListener