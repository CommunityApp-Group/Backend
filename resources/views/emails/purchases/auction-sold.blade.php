<p>Your Auction <a href="{{route('lots.show', $lot->id)}}">{{ $lot->name }}</a>
    was purchased by {{ $buyer->name }} for a price of {{ $price }}.</p>
