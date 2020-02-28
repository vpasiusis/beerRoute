
    <!doctype html>
    <html lang="{{ app()->getLocale() }}">
    <head>
        <title>View Products | Product Store</title>
        
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <h1>Here's a list of beers</h1>
                <table>
                    <thead>
                        <td>Name</td>
                    </thead>
                    <tbody>
                        @foreach ($beers as $beer)
                            <tr>
                                <td>{{ $beer->id }}</td>
                                <td>{{ $beer->name }}</td>
                            </tr>
                        @endforeach
                       
                    </tbody>
                </table>
                {{$beers->links()}}
            </div>
        </div>
    </body>
    </html>