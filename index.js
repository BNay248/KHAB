        function addInstructionField() {
            const instructionsContainer = document.getElementById('instructionsContainer');
            const inputFields = instructionsContainer.querySelectorAll('input[type="text"]');
            const instructionCount = inputFields.length;
            const newInstruction = document.createElement('input');
            newInstruction.type = 'text';
            newInstruction.placeholder = 'Instruction';
            newInstruction.id = 'instruction' + (instructionCount + 1);
            newInstruction.required = true;
            instructionsContainer.appendChild(newInstruction);
            instructionsContainer.appendChild(document.createElement('br'));
        }

        function addIngredientField() {
            const ingredientsContainer = document.getElementById('ingredientsContainer');
            const ingredientCount = ingredientsContainer.querySelectorAll('.ingredient').length;
            
            const nameField = document.createElement('input');
            nameField.type = 'text';
            nameField.placeholder = 'Ingredient Name';
            nameField.id = 'ingredient' + (ingredientCount + 1) + 'Name';
            nameField.required = true;

            const quantField = document.createElement('input');
            quantField.type = 'text';
            quantField.placeholder = 'Ingredient Quant';
            quantField.id = 'ingredient' + (ingredientCount + 1) + 'Quant';
            quantField.required = true;

            const unitField = document.createElement('input');
            unitField.type = 'text';
            unitField.placeholder = 'Ingredient Unit';
            unitField.id = 'ingredient' + (ingredientCount + 1) + 'Unit';
            unitField.required = true;

            const ingredientDiv = document.createElement('div');
            ingredientDiv.classList.add('ingredient');
            ingredientDiv.appendChild(nameField);
            ingredientDiv.appendChild(document.createElement('br'));
            ingredientDiv.appendChild(quantField);
            ingredientDiv.appendChild(document.createElement('br'));
            ingredientDiv.appendChild(unitField);
            ingredientDiv.appendChild(document.createElement('br'));
            ingredientDiv.appendChild(document.createElement('br'));

            ingredientsContainer.appendChild(ingredientDiv);
        }

        function sendData() {
            const instructions = [];
            const instructionsContainer = document.getElementById('instructionsContainer');
            const instructionFields = instructionsContainer.querySelectorAll('input[type="text"]');
            instructionFields.forEach(input => instructions.push(input.value));

            const ingredients = [];
            const ingredientsContainer = document.getElementById('ingredientsContainer');
            const ingredientDivs = ingredientsContainer.querySelectorAll('.ingredient');
            ingredientDivs.forEach(ingredientDiv => {
                const name = ingredientDiv.querySelector('input[id*="Name"]').value;
                const quantity = ingredientDiv.querySelector('input[id*="Quant"]').value;
                const unit = ingredientDiv.querySelector('input[id*="Unit"]').value;
                ingredients.push({ name, quantity, unit });
            });

            const data = {
                "username": document.getElementById("username").value,
                "title": document.getElementById("recipeName").value,
                "image_url": document.getElementById("imgUrl").value,
                "linktype": "recipe",
                "instructions": instructions,
                "ingredients": ingredients,
                "landing_page_configuration": {
                    "partner_lineback_url": "string",
                    "enable_pantry_items": "true"
                }
            };

            fetch("create-json.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                window.alert("Success: " + result);
            });
        }
		
		async function search(){
			const data = {
				directory: document.getElementById("username").value,
				keyword: document.getElementById("keyword").value
			};
			
			const response = await fetch("search.php", {
				method: "POST",
				headers: {
					"Content-Type": "application/json"
				},
				body: JSON.stringify(data)
			})
			const result = await response.json();
			document.getElementById('jsonOutput').textContent = JSON.stringify(result, null, 2);
		}

        function login() {
            const data = {
                username: document.getElementById("username").value,
                pin: document.getElementById("pin").value
            };

            fetch("login.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if (result === 'pin') {
                    window.alert('Incorrect Pin');
                } else if (result === 'user') {
                    window.alert('Could not find User');
                } else {
                    document.getElementById('recipeForm').style.display = 'block';
					document.getElementById('rightPane').style.display = 'block';
					document.getElementById('loginForm').style.display = 'none';
                }
            });
        }

        function createUser() {
            const data = {
                username: document.getElementById("username").value,
                pin: document.getElementById("pin").value
            };

            fetch("create-user.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                window.alert("Success: " + result);
            });
        }
		
		function share() {
            const data = {
                username: document.getElementById("username").value,
				title: document.getElementById("title").value,
                newusername: document.getElementById("share").value
            };

            fetch("share.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
				if(result === 'user'){
					window.alert('No user exists with that username');
					return;
				}
                window.alert(result);
            });
        }

        function pullRecipe() {
			const data = {
                username: document.getElementById("username").value,
                title: document.getElementById("title").value
            };
            fetch("pullRecipe.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('jsonOutput').textContent = JSON.stringify(data, null, 2);
            })
        }
		
		function logOut() {
			location.reload();
		}
    