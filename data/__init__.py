# Acts as the REST API back-end to accept GET, POST, and DELETE requests

import markdown
import os
import shelve
import pickle
import datetime
from Hash import Hash

# Import the framework
from flask import Flask, g
from flask_restful import Resource, Api, reqparse

# Create an instance of Flask
app = Flask(__name__)

#Creat the API
api = Api(app)

# Loads the saved hashmap to continue where the API left off
hashID = pickle.load( open( "data/hash_map.p", "rb" ) )

# function freezes and saves the hashmap object to a pickle file
def saveData():
    pickle.dump(hashID, open("data/hash_map.p", "wb") )

# function opens the photos database file to be interacted with
def get_db():
    db = getattr(g, '_database', None)
    if db is None:
        db = g._database = shelve.open("photos.db")
    return db 

@app.teardown_appcontext
def teardown_db(exception):
    db = getattr(g, '_database', None)
    if db is not None:
        db.close()

@app.route("/")
def index():
    '''Present some documentation'''

    # Open the README file
    with open(os.path.dirname(app.root_path) + '/README.md', 'r') as markdown_file:

        # Read the conetnet of the file
        content = markdown_file.read()

        # Convert to HTML
        return markdown.markdown(content)

# Object allows GET and POST requests for the entire database
class PhotoList(Resource):

    # GET request to photos returns the JSON for all of the photos in the database
    def get(self):
        shelf = get_db()
        keys = list(shelf.keys())
        
        photos = []

        for key in keys:
            photos.append(shelf[key])
        
        # On success, returns a 200 status
        return {'message': 'Success', 'data' : photos}, 200
    
    # POST request to photos appends new photo to the database
    def post(self):
        parser = reqparse.RequestParser()
        shelf = get_db()
        
        # Parses the request for given arguments
        parser.add_argument('file_name', required=True)
        parser.add_argument('size', required=True)
        parser.add_argument('descriptor', required=True)

        #Parse the arguments into an object
        args = parser.parse_args()
        
        # The filename is passed through the hashmap object to get a unique identifier
        args['identifier'] = str(hashID.generate(args['file_name']))
        args['date_modified'] = str(datetime.datetime.now())

        # Appends the new photo metadata to the database
        shelf = get_db()
        shelf[args['identifier']] = args
        
        # Freezes and saves the hashmap object to the pickle file
        saveData()
        
        # On success, returns a 201 status
        return {'message' : 'Photo registered', 'data' : args}, 201


# Object allows GET and DELETE requests for specific photos
class Photo(Resource):
    # GET request gets metadata for photo based on identifier
    def get(self, identifier):
        shelf = get_db()

        # If the key does not exist in the data store, return a 404 error
        if not (identifier in shelf):
            return {'message': 'Photo not found', 'data':{}}, 404

        # On success, returns 200 status
        return {'message': 'Photo found', 'data': shelf[identifier]}, 200

    # DELETE request deleetes photo from the database based on identifier
    def delete(self, identifier):
        # Deletes identfier from hashmap and saves the object
        hashID.array [int(identifier)] = -1
        saveData()

        shelf = get_db()

        # If the key doe not exist in the data store, return a 404 error
        if not (identifier in shelf):
            return {'message':'Photo not found', 'data':{}}, 404

        del shelf[identifier]
        
        # On success, returns 204 status
        return '', 204

api.add_resource(PhotoList, '/photos')
api.add_resource(Photo, '/photos/<string:identifier>')
