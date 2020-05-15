#!/usr/bin/env python

# Script uses the saved hashmap object from data/__init__.py to get the identifier for a photo

import pickle
import sys
from Hash import Hash

hashID = pickle.load( open( "/home/pi/code/MY_API/data/hash_map.p", "rb" ) )

# The filename is given as the first argument in the cmd line
print(hashID.search((sys.argv [1])))
